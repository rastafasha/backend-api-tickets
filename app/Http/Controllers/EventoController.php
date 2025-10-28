<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Evento;
use App\Models\Cliente;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Representante;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Evento\EventoResource;
use App\Http\Resources\Evento\EventoCollection;

class EventoController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $events = Evento::orderBy("id", "desc")
        // ->paginate(10);
        ->get();
                    
        return response()->json([
            // "total" =>$events->total(),
            "events" => $events,
            // "events" => EventoCollection::make($events),
            
        ]);          
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        
        $event = App\Models\Evento::findOrFail($id);
    
        return response()->json($event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event_is_valid = Evento::where("id", $request->id)->first();

        if($event_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'el paciente ya existe'
            ]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("events", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        if($request->fecha_inicio){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->fecha_inicio );
            $request->request->add(["fecha_inicio" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->fecha_fin){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->fecha_fin );
            $request->request->add(["fecha_fin" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }
        

        $event = Evento::create($request->all());

        // Generate initial debt for the newly registered event
        app(\App\Http\Controllers\Admin\AdminPaymentController::class)->generateInitialDebtForevent($event->id);

        $request->request->add([
            "event_id" =>$event->id
        ]);
        
        
        return response()->json([
            "message"=>200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Evento::find($id);

        // //buscamos los eventos donde id sea igual client_id
        // $event = Evento::with(['clientes' => function ($query) {
        //     $query->where('id', 'client_id');
        // }])
        // // ->with(['eventos' => function ($query) {
        // //     $query->select('id', 'client_id');
        // // }])
        // ->findOrFail($id);

        return response()->json([
            // "event" => EventoResource::make($event),
            "event" => $event,
        ]);

       
    }

    public function clientsbyEvent(Request $request, $id)
    {
        $event = Evento::findOrFail($id);
        $clientes = Cliente::where("id", $id)->orderBy('created_at', 'DESC')
    
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'event' => $event,
            "clientes" => $clientes,
        ], 200);
    }


     public function eventsByUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $eventos = Evento::where("user_id", $id)->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user' => $user,
            "eventos" => $eventos,
        ], 200);
    }


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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $event_is_valid = Evento::where("id", "<>", $id)->where("n_doc", $request->n_doc)->first();

        // if($event_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el paciente ya existe'
        //     ]);
        // }
        
        $event = Evento::findOrFail($id);
        if($request->hasFile('imagen')){
            if($event->avatar){
                Storage::delete($event->avatar);
            }
            $path = Storage::putFile("events", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        if($request->fecha_inicio){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->fecha_inicio );
            $request->request->add(["fecha_inicio" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }
        if($request->fecha_fin){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->fecha_fin );
            $request->request->add(["fecha_fin" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }
        
        $event->update($request->all());

        return response()->json([
            "message"=>200,
            "event"=>$event
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Evento::findOrFail($id);
        if($event->avatar){
            Storage::delete($event->avatar);
        }
        $event->delete();
        return response()->json([
            "message"=>200
        ]);
    }


    public function search(Request $request){
        return Evento::search($request->buscar);
    }

    public function updateStatus(Request $request, $id)
    {
        $event = Evento::findOrfail($id);
        $event->status = $request->status;
        $event->update();
        return $event;
    }

}
