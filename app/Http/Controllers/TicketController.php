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
            "ticket_id" =>$ticket->id
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
    public function showbyEvent($event_id)
    {
        $tickets = Ticket::where('event_id', $event_id)->get();

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
            "message"=>200,
            "ticket"=>$ticket
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
            "message"=>200,
            "ticket"=>$ticket
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
            "message"=>200
        ]);
    }



    public function shared($client_id)
    {

        $tickets = Ticket::
                where('from_id', '=', $client_id)

                ->where('status', '=', 'SHARED')
                ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar Post destacados',
                "tickets" => TicketCollection::make($tickets),
            ], 200);
    }
}
