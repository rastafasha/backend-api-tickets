<?php

namespace App\Http\Controllers;

use App\Http\Resources\Ticket\TicketCollection;
use App\Http\Resources\Ticket\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $tickets = Ticket::orderBy("id", "desc")
            ->get();

        return response()->json([
            "tickets" => $tickets,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTicket(Request $request)
    {

        $ticket = Ticket::create($request->all());



        $request->request->add([
            "ticket_id" => $ticket->id
        ]);


        return response()->json([
            "message" => 200,
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
        $ticket = Ticket::find($id);

        return response()->json([
            "ticket" => TicketResource::make($ticket),

        ]);
    }

    public function showbyClient($from_id)
    {
        $tickets = Ticket::where('from_id', $from_id)->get();

        return response()->json([
            "tickets" => TicketCollection::make($tickets),

        ]);
    }
    public function showbyEvent(Request $request, $event_id, $client_id )
    {
        $tickets = Ticket::where('event_id', $event_id)
        ->where('client_id', $client_id)
        ->where('status', '=', 'ACTIVE')
        ->get();

        return response()->json([
            "tickets" => TicketCollection::make($tickets),

        ]);
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

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return response()->json([
            "message" => 200,
            "ticket" => $ticket
        ]);
    }

    public function compartir(Request $request, $id)
    {

        $ticket = Ticket::findOrFail($id);
        // $ticket->update($request->all());

        $ticket->update([
            'from_id' => $request->from_id,
            'client_id' => $request->client_id,
            'status' => 'SHARED',
        ]);

        return response()->json([
            "message" => 200,
            "ticket" => $ticket
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
        $ticket = Ticket::findOrFail($id);

        $ticket->delete();
        return response()->json([
            "message" => 200
        ]);
    }



    public function shared($client_id)
    {

        $tickets = Ticket::
            where('client_id', '=', $client_id)
            ->where('status', '=', 'SHARED')
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar tickets compartidos recibidos',
            "tickets" => TicketCollection::make($tickets),
        ], 200);
    }

    public function tiketsactivosCompartidos(Request $request, $client_id)
    {

        $tickets = Ticket::
            where('client_id', '=', $client_id)

            ->where('status', '=', 'SHAREDACTIVE')
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar tickets  activos compartidos',
            "tickets" => TicketCollection::make($tickets),
        ], 200);
    }

    public function tiketsactivos(Request $request, $client_id)
    {

        $tickets = Ticket::
            where('client_id', '=', $client_id)

            ->where('status', '=', 'ACTIVE')
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar tickets compartidos activos recibidos',
            "tickets" => TicketCollection::make($tickets),
        ], 200);
    }


    public function search(Request $request){
        return Ticket::search($request->buscar);

        // return response()->json([
        //     'code' => 200,
        //     'status' => 'Listar ticket por referencia',
        //     "ticket" => Ticket::search($request->buscar),
        // ], 200);
    }



    public function verify(Request $request)
    {
        $referencia = $request->referencia;
        $ticket = Ticket::where('referencia', $request->referencia)
            // ->where('event_id', $request->event_id)
            // ->where('status', 'ACTIVE')
            ->first();

        // Check if ticket exists
        if (!$ticket) {
            return response()->json([
                'code' => 404,
                'status' => 'Ticket no encontrado',
                'referencia' => $referencia,
            ], 404);
        }

        // Update the ticket
        $ticket->update([
            'from_id' => $request->from_id,
            'client_id' => $request->client_id,
            'status' => 'EXPIRED',
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'Verificar ticket por codigo y evento',
            'referencia' => $referencia,
            "ticket" => TicketResource::make($ticket),
        ], 200);
    }

}
