<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Representante;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Representante\RepresntanteResource;

class RepresentanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $clientes = Cliente::orderBy('id', 'desc')
            
            ->with(['payments' => function ($query) {
                $query->where('status_deuda', 'DEUDA')->select('id', 'client_id', 'status_deuda');
            }])
            ->with(['eventos' => function ($query) {
                $query->select('id', 'client_id');
            }])
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los Usuarios con pagos en deuda',
            'clientes' => $clientes
            // "clientes" => RepresntanteResource::make($clientes)
        ], 200);
    }

    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //buscamos por el id

        $cliente = Cliente::findOrFail($id);
       
        //buscamos los pagos y los eventos donde id sea igual client_id
        // $cliente = Cliente::with(['payments' => function ($query) {
        //     $query->where('status_deuda', 'DEUDA')->select('id', 'client_id', 'status_deuda');
        // }])
        // ->with(['eventos' => function ($query) {
        //     $query->select('id', 'client_id');
        // }])
        // ->findOrFail($id);


        return response()->json([
            "cliente" => $cliente

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $cliente_is_valid = Cliente::where("id", "<>", $id)->where("email", $request->email)->first();
        $role_new = null;
        if($cliente_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'el usuario con este email ya existe'
            ]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("clients", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        $cliente = Cliente::findOrFail($id);
        
        $cliente->update($request->all());

        if($request->role_id && $request->role_id != $cliente->roles()->first()->id){
            // error_log($cliente->roles()->first()->id);
            $role_old = Role::findOrFail($cliente->roles()->first()->id);
            $cliente->removeRole($role_old);
            // error_log($request->role_id);
            $role_new = Role::findOrFail($request->role_id);
            $cliente->assignRole($role_new);
        }
        
        
        return response()->json([
            "message" => 200,
            "cliente" => $cliente->{$role_new}
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDestroy(cliente $cliente)
    {
        // $this->authorize('delete', Cliente::class);
        
        try {
            DB::beginTransaction();

            $cliente->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Usuario delete',
            ], 200);

        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Borrado fallido. Conflicto',
            ], 409);

        }
    }

    protected function userInput(): array
    {
        return [
            "name" => request("name"),
            "email" => request("email"),
            "rolename" => request("rolename"),
        ];
    }

    public function recientes()
    {
        // $this->authorize('recientes', Cliente::class);

        $clientes = Cliente::orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'clientes' => $clientes
        ], 200);
    }

    public function search(Request $request){
        return Cliente::search($request->buscar);
    }

    public function showNdoc($n_doc)
    {
       
        $data_patient = [];
       
        
        $cliente = Cliente::where('n_doc', $n_doc)
        ->orderBy('id', 'desc')
        ->get();
        // $patient = Patient::where('n_doc', $n_doc)
        // ->orderBy('id', 'desc')
        // ->get();
        
        //     return response()->json([
        //         'code' => 200,
        //         'status' => 'Listar patient by n_doc',
        //         "user" => PatientCollection::make($cliente) ,
        //         "patient" => PatientCollection::make($patient) ,
        //     ], 200);
    }

     public function updateStatus(Request $request, $id)
    {
        $cliente = Cliente::findOrfail($id);
        $cliente->status = $request->status;
        $cliente->update();
        return $cliente;
    }
}
