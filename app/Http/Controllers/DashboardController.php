<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Student;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function config()
    {
        $clients = Cliente::orderBy('id', 'desc')
            ->paginate(10);

        $clients_deuda = Cliente::orderBy('id', 'desc')
            
            ->with(['payments' => function ($query) {
                $query->where('status_deuda', 'DEUDA')->select('id', 'client_id', 'status_deuda');
            }])
            ->paginate(10);
        $clients_nodeuda = Cliente::orderBy('id', 'desc')
            
            ->with(['payments' => function ($query) {
                // $query->where('status_deuda', 'PAID')->select('id', 'client_id', 'status_deuda');
                $query->where('status', 'APPROVED')->select('id', 'client_id', 'status_deuda');
            }])
            ->paginate(10);

        $events = Evento::orderBy("id", "desc")
        ->paginate(10);
                    
        return response()->json([
            "total_clients" =>$clients->total(),
            "clients_nodeuda" =>$clients_nodeuda->total(),
            "total_clients_deuda" =>$clients_deuda->total(),
            "total_events" =>$events->total(),
            
        ]); 
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
