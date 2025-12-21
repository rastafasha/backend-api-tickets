<?php

namespace App\Http\Controllers\Admin;


use App\Models\Cliente;
use Carbon\Carbon;
use App\Models\Evento;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Tasabcv;
use App\Helpers\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Mail\EnrollmentNotificationMail;
use App\Http\Resources\Appointment\Payment\PaymentCollection;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminPaymentController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $metodo = $request->metodo;
        $search_referencia = $request->search_referencia;
        $bank_name = $request->bank_name;
        $bank_destino = $request->bank_destino;
        $nombre = $request->nombre;
        $monto = $request->monto;
        $fecha = $request->fecha;
        $deuda = $request->deuda;
        $status_deuda = $request->status_deuda;
        $status = $request->status;


        $payments = Payment::filterAdvancePayment($search_referencia, 
        $bank_name, $bank_destino,
        $monto,
        $metodo,
        $nombre,
        $fecha,
        $deuda,
$status_deuda,
$status,
        )->orderBy("id", "desc")
                            ->paginate(1000);
                            // ->get();
                    
        return response()->json([
            "total"=>$payments->total(),
            "payments" => $payments ,
            // "payments" => PaymentCollection::make($payments) ,
            
        ]);  
    }

    /**
     * Pay the debt for a student under a parent.
     * Creates a payment and updates status_deuda to PAID if amount equals debt.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $client_id
     * @param int $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function payDebtForEvent(Request $request, $client_id, $event_id)
    {
        // Fetch the event to get prices
        $event = Evento::find($event_id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Check if client has already purchased 5 tickets for this event
        $ticketCount = $event->getTicketCountForClient($client_id);
        if ($ticketCount >= 5) {
            return response()->json(['error' => 'Client has reached the maximum limit of 5 tickets per event'], 400);
        }

        // Determine selected price based on tipo
        $tipo = $request->input('tipo', 'general');
        switch ($tipo) {
            case 'general':
                $selected_price = $event->precio_general;
                break;
            case 'estudiantes':
                $selected_price = $event->precio_estudiantes;
                break;
            case 'especialistas':
                $selected_price = $event->precio_especialistas;
                break;
            default:
                $selected_price = $event->precio_general;
        }

        if ($selected_price === null) {
            return response()->json(['error' => 'Selected price not available for this event type'], 400);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("payments", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        $monto = $request->input('monto');
        $metodo = $request->input('metodo');

        // Remove commas from monto string to allow numeric check
        $monto = str_replace(',', '', $monto);

        if (!is_numeric($monto) || $selected_price <= 0) {
            return response()->json(['error' => 'Invalid payment amount'], 400);
        }

        $monto = floatval($monto);

        $originalMonto = $monto;

        // if ($metodo === 'Transferencia Bolívares' || $metodo === 'Pago Móvil') {
        //     $tasabcv = Tasabcv::latest()->first();
        //     if ($tasabcv && $tasabcv->precio_dia > 0) {
        //         // Adjust monto by dividing by precio_dia to get comparable amount
        //         $monto = $monto / $tasabcv->precio_dia;
        //     } else {
        //         return response()->json(['error' => 'Precio dia not found or invalid'], 400);
        //     }
        // }

        // Compare adjusted monto with selected price
        if ($monto == $selected_price) {
            $status_deuda = 'PAID';
        } else {
            $status_deuda = 'DEUDA';
        }

        // Debug logs for troubleshooting
        \Log::info("payDebtForEvent: originalMonto={$originalMonto}, adjustedMonto={$monto}, selectedPrice={$selected_price}, status_deuda={$status_deuda}, metodo={$metodo}");

        // Create new payment record
        $payment = new Payment();
        $payment->client_id = $client_id;
        $payment->event_id = $event_id;
        $payment->monto = $monto;
        $payment->status_deuda = $status_deuda;

        // $payment->status = 'PAID'; // Assuming payment status is PAID when payment is made
        $payment->metodo = $metodo;
        $payment->referencia = $request->referencia;
        $payment->bank_name = $request->bank_name;
        $payment->bank_destino = $request->bank_destino;
        $payment->nombre = $request->nombre;
        $payment->email = $request->email;
        $payment->avatar = $request->avatar;
        $payment->status = $request->status;
        $payment->save();

        //agregamos el client_id y event_id a la relacion de eventos_clientes
        
        DB::table('eventos_clientes')->updateOrInsert(
            [
                'event_id' => $event_id,
                'client_id' => $client_id
            ],
            [
                'updated_at' => now(),
                'created_at' => now()
            ]
        );  

        // Update existing unpaid debts by applying the payment amount
        $remainingAmount = $monto;
        $unpaidDebts = Payment::where('client_id', $client_id)
            ->where('event_id', $event_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($unpaidDebts as $debt) {
            if ($remainingAmount <= 0) {
                break;
            }

            if ($debt->monto <= $remainingAmount) {
                // Mark this debt as paid
                $debt->status_deuda = 'PAID';
                // $debt->status = 'APPROVED';
                $debt->status = 'PENDING';
                $remainingAmount -= $debt->monto;
            } else {
                // Partial payment: reduce the debt amount
                $debt->monto -= $remainingAmount;
                $remainingAmount = 0;
            }
            $debt->save();
        }

        //envio de correo al doctor
        // Mail::to($appointment->doctor->email)->send(new NewPaymentRegisterMail($payment));

        return response()->json([
            'message' => 'Payment recorded successfully and debt updated',
            'payment' => $payment,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentShow(Payment $payment)
    {
       

        if (!$payment) {
            return response()->json([
                'message' => 'Pago not found.'
            ], 404);
        }
        


        return response()->json([
            'code' => 200,
            'status' => 'success',
            // "payment" => PaymentResource::make($payment),
            "payment" => $payment,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentUpdate(Payment $request,  $id)
    {
        try {
            DB::beginTransaction();

            $request = $request->all();
            $payment = Payment::find($id);
            $payment->update($request->all());


            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Update payment success',
                'payment' => $payment,
            ], 200);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error no update'  . $exception,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentDestroy(Payment $payment)
    {
        $this->authorize('paymentDestroy', Payment::class);

        try {
            DB::beginTransaction();

            if ($payment->image) {
                Uploader::removeFile("public/payments", $payment->image);
            }

            $payment->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Pago delete',
            ], 200);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Borrado fallido. Conflicto',
            ], 409);
        }
    }

   
    public function recientes()
    {
        $payments = Payment::orderBy('created_at', 'DESC')
        ->paginate(10);
        // ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'payments' => $payments
        ], 200);
    }


     public function search(Request $request){
        return Payment::search($request->buscar);
    }





    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrfail($id);
        $payment->status = $request->status;

        if ($request->status === 'REJECTED') {
            $payment->status_deuda = 'DEUDA';
        }
        if ($request->status === 'APPROVED') {
            $payment->status_deuda = 'PAID';
             // si el pago es positivo, generamos un ticket con los datos de la compra,
             // llaando a la funcion storeTicket en ticketController

             $this->storeTicket($request, $payment);

        }

        $payment->update();
        return $payment;
    

    }


    public function pagosbyUser(Request $request, $client_id)
    {
        
        $payments = Payment::where("client_id", $client_id)
        ->orderBy('created_at', 'DESC')
        ->with('event')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            // "payments" => PaymentCollection::make($payments),
            "payments" => $payments,
        ], 200);
    }

       public function pagosPendientesbyStudent(Request $request, $event_id)
    {
        $payments = Payment::where("event_id", $event_id)
        ->orderBy('created_at', 'DESC')
        // ->with('student')
        ->get();

        return response()->json([
            // "total" => $payments->total(),
            "payments" => $payments,
        ]);
    }
    
     public function pagosPendientes()
    {
        
        $payments = Payment::where('status', 'PENDING')->orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            "total"=>$payments->total(),
            "payments"=> PaymentCollection::make($payments)
        ]);

    }

    /**
     * Send enrollment notification emails to representatives at the end and beginning of the month.
     */
    public function sendEnrollmentNotificationEmails()
    {
        $now = Carbon::now();
        $day = $now->day;

        // Only proceed if today is between 28-31 or 1-3 of the month
        if (($day >= 28 && $day <= 31) || ($day >= 1 && $day <= 3)) {
            // Find eventos with pending enrollment payments or relevant criteria
            $eventos = Evento::whereHas('payments', function ($query) {
                $query->where('status_deuda', '!=', 'PAID');
            })->get();

            foreach ($eventos as $evento) {
                $client = $evento->client;
                if ($client && $client->email) {
                    Mail::to($client->email)->send(new EnrollmentNotificationMail($evento));
                }
            }

            return response()->json([
                'message' => 'Enrollment notification emails sent successfully.',
                'date' => $now->toDateString(),
            ]);
        } else {
            return response()->json([
                'message' => 'Today is not within the notification period.',
                'date' => $now->toDateString(),
            ]);
        }
    }

    /**
     * Check if the representative (parent) and student have debt and the amount.
     *
     * @param int $client_id
     * @param int $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDebtStatusByParent($client_id)
    {
        // Sum unpaid payments for the representative (parent)
        $clientDebt = Payment::where('parent_id', $client_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', '=','PENDING');
            })
            ->sum('monto');

        // Get eventos with debt and their debt details
        $eventosWithDebt = Payment::select('event_id', DB::raw('SUM(monto) as total_debt'), DB::raw('MIN(created_at) as earliest_debt_date'))
            ->where('parent_id', $client_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', '=','PENDING');
            })
            ->groupBy('event_id')
            ->with('student:id,name,matricula') // assuming student has 'name' attribute
            ->get();

        $eventosDebtDetails = $eventosWithDebt->map(function ($item) {
            return [
                'event_id' => $item->event_id,
                'student_name' => $item->student ? $item->student->name : null,
                'matricula' => $item->student ? $item->student->matricula : null,
                'debt_amount' => $item->total_debt,
                'earliest_debt_date' => $item->earliest_debt_date,
            ];
        });

        return response()->json([
            'parent_id' => $client_id,
            'parent_has_debt' => $clientDebt > 0,
            'parent_debt_amount' => $clientDebt,
            'eventos_with_debt' => $eventosDebtDetails,
        ]);
    }
    public function checkDebtStatus($client_id, $event_id)
    {
        // Sum unpaid payments for the representative (parent)
        $clientDebt = Payment::where('parent_id', $client_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', '=','PENDING');
            })
            ->sum('monto');

        // Sum unpaid payments for the student
        $eventoDebt = Payment::where('event_id', $event_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', '=','PENDING');
            })
            ->sum('monto');

        return response()->json([
            'parent_id' => $client_id,
            'event_id' => $event_id,
            'parent_has_debt' => $clientDebt > 0,
            'parent_debt_amount' => $clientDebt,
            'student_has_debt' => $eventoDebt > 0,
            'student_debt_amount' => $eventoDebt,
        ]);
    }

    /**
     * View the debt of each student for a given parent (representative).
     *
     * @param int $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewDebtByParent($client_id)
    {
        // Get eventos of the parent with their total debt amount
        $eventosWithDebt = Payment::select('event_id', DB::raw('SUM(monto) as total_debt'))
            ->where('parent_id', $client_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                ->where('status','=',  'REJECTED')
                      ->orWhere('status','=', 'PENDING');
            })
            ->groupBy('event_id')
            ->with('student:id,name,matricula') // assuming student has 'name' attribute
            ->get();

        $eventosDebtDetails = $eventosWithDebt->map(function ($item) {
            return [
                'event_id' => $item->event_id,
                'student_name' => $item->student ? $item->student->name : null,
                'matricula' => $item->student ? $item->student->matricula : null,
                'debt_amount' => $item->total_debt,
            ];
        });

        return response()->json([
            'parent_id' => $client_id,
            'eventos_with_debt' => $eventosDebtDetails,
        ]);
    }

    /**
     * Pay the debt for a student under a parent.
     * Creates a payment and updates status_deuda to PAID if amount equals debt.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $client_id
     * @param int $event_id
     * @return \Illuminate\Http\JsonResponse
     */



    public function paymentbyevent(Request $request, $event_id)
    {
        $event = Evento::findOrFail($event_id);
        $payments = Payment::where("event_id", $event_id)->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'event' => $event,
            "payments" => $payments,
            // "events" => eventCollection::make($events),
        ], 200);
    }
    public function paymentbyeventbyclient(Request $request, $event_id, $client_id, )
    {
        $event = Evento::findOrFail($event_id);
        $client = Cliente::findOrFail($client_id);
        $payments = Payment::where("event_id", $event_id)
        ->where("client_id", $client_id)
        ->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'event' => $event,
            'client' => $client,
            "payments" => $payments,
            // "events" => eventCollection::make($events),
        ], 200);
    }



    /**
     * Store a new ticket based on approved payment.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTicket(Request $request, Payment $payment)
    {
        try {
            // Get the related event and client
            $event = Evento::find($payment->event_id);
            $client = Cliente::find($payment->client_id);
            
            if (!$event || !$client) {
                return response()->json([
                    'error' => 'Event or Client not found'
                ], 404);
            }

            // Check if ticket already exists for this payment
            $existingTicket = Ticket::where('referencia', $payment->referencia)->first();
            if ($existingTicket) {
                return response()->json([
                    'message' => 'Ticket already exists for this payment',
                    'ticket' => $existingTicket
                ]);
            }

            // Generate QR code data
            $qrCodeData = json_encode([
                'ticket_id' => uniqid('TKT-'),
                'payment_id' => $payment->id,
                'client_id' => $payment->client_id,
                'client_name' => $client->name ?? '',
                'event_id' => $payment->event_id,
                'event_name' => $event->name ?? 'Event',
                'referencia' => $payment->referencia,
                'monto' => $payment->monto,
                'fecha_evento' => $event->fecha_inicio ?? '',
                'created_at' => now()->toISOString(),
                'verification_url' => url('/api/tickets/verify/' . $payment->referencia)
            ]);
            



            // Generate QR code using external API (more reliable)
            try {
                // Use QRCode API service for generating QR codes
                $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/';
                $qrParams = http_build_query([
                    'size' => '300x300',
                    'data' => $qrCodeData,
                    'format' => 'png',
                    'margin' => '10'
                ]);
                
                $qrApiUrl .= '?' . $qrParams;
                
                // Fetch QR code image from API
                $qrImageContent = file_get_contents($qrApiUrl);
                
                if ($qrImageContent !== false) {
                    // Convert to base64 string
                    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrImageContent);
                } else {
                    throw new \Exception('Failed to fetch QR code from API');
                }
                
            } catch (\Exception $qrException) {
                // Fallback: Use Simple-QRCode library if available, or text-based QR
                \Log::warning('QR Code API failed, trying library fallback: ' . $qrException->getMessage());
                
                try {
                    // Try Simple-QRCode library with minimal configuration
                    $qrCodeImage = QrCode::size(200)->generate($qrCodeData);
                    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage);
                } catch (\Exception $libraryException) {
                    // Final fallback: Store QR data as text
                    \Log::warning('Both QR methods failed, using text fallback: ' . $libraryException->getMessage());
                    $qrCodeBase64 = 'QR_TEXT:' . $qrCodeData;
                }
            }
            
            // Create the ticket
            $ticket = Ticket::create([
                'client_id' => $payment->client_id,
                'company_id' => $event->company_id ?? null, // Set if available in event
                'event_id' => $payment->event_id,
                'event_name' => $event->name ?? 'Event', // Get event name
                'referencia' => $payment->referencia,
                'monto' => $payment->monto,
                'fecha_inicio' => $event->fecha_inicio ?? null, // Get from event
                'fecha_fin' => $event->fecha_fin ?? null, // Get from event
                'qr_code' => $qrCodeBase64 // Store QR code as base64 data URL
            ]);

            return response()->json([
                'message' => 'Ticket created successfully with QR code',
                'ticket' => $ticket
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating ticket: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create ticket',
                'message' => $e->getMessage()
            ], 500);
        }
    }



}

