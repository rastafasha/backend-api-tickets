<?php

namespace App\Http\Controllers;

use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Evento;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
      
        $companies = Company::orderBy("id", "desc")
        ->get();
                    
        return response()->json([
            // "companies" => $companies,
            "companies" => CompanyCollection::make($companies),
            
        ]);          
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function companyStore(Request $request)
    {
        $company_is_valid = Company::where("id", $request->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if($company_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'la empresa  ya existe'
            ]);
        }


        if($request->hasFile('imagen')){
            $path = Storage::putFile("companies", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        
        $company = Company::create($request->all());

       

        $request->request->add([
            "company_id" =>$company->id
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
        $company = Company::find($id);

        return response()->json([
            "company" => CompanyResource::make($company),
            
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

        $company = Company::findOrFail($id);

       if($request->hasFile('imagen')){
            if($company->avatar){
                Storage::delete($company->avatar);
            }
            $path = Storage::putFile("companies", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        
        $company->update($request->all());

       

        return response()->json([
            "message"=>200,
            "company"=>$company
        ]);
    }


    public function companyUpdate(Request $request, $id)
    {

        $company = Company::findOrFail($id);
        if($request->hasFile('imagen')){
            if($company->avatar){
                Storage::delete($company->avatar);
            }
            $path = Storage::putFile("companies", $request->file('avatar'));
            $request->request->add(["avatar"=>$path]);
        }
        
       
        $user_id = $request->user_id;
        $company_id = $request->company_id;

        
        DB::table('company_users')->updateOrInsert(
            [
                'company_id' => $company_id,
                'user_id' => $user_id
            ],
            [
                'updated_at' => now(),
                'created_at' => now()
            ]
        );  

        $company->update($request->all());

        // Sync eventos if provided
        if ($request->has('eventos_ids') && is_array($request->eventos_ids)) {
            $company->eventos()->sync($request->eventos_ids);
        }

        return response()->json([
            "message"=>200,
            "company"=>$company
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
       $company = Company::findOrFail($id);
        if($company->avatar){
            Storage::delete($company->avatar);
        }
        $company->delete();
        return response()->json([
            "message"=>200
        ]);
    }

    public function search(Request $request){
        return Company::search($request->buscar);
    }



     public function addEvent(Request $request, $id)
    {
       
        $company = Company::findOrFail($id);
        
        $event_id = $request->event_id;
        $company_id = $request->company_id;

        
        DB::table('eventos_company')->updateOrInsert(
            [
                'company_id' => $company_id,
                'event_id' => $event_id
            ],
            [
                'updated_at' => now(),
                'created_at' => now()
            ]
        );  
        
        $company->update($request->all());

        // Sync events if provided
        if ($request->has('event_ids') && is_array($request->event_ids)) {
            $company->events()->sync($request->event_ids);
        }

        return response()->json([
            "message"=>200,
            "company"=>$company
        ]);
    }
    public function removeEvent(Request $request, $id)
    {
        $event_id = $request->event_id;
        $company_id = $request->company_id;

        DB::table('eventos_company')
            ->where('company_id', $company_id)
            ->where('event_id', $event_id)
            ->delete();

        return response()->json([
            "message" => 200,
        ]);
    }


    public function eventsbyCompany(Request $request, $company_id)
    {
        $company = Company::findOrFail($company_id);
        $events = Evento::whereHas('company', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'company' => $company,
            'events' => $events,
        ], 200);
    }


     public function addEmployee(Request $request, $id)
    {
       
        $company = Company::findOrFail($id);
        
        $user_id = $request->user_id;
        $company_id = $request->company_id;

        
        DB::table('company_users')->updateOrInsert(
            [
                'company_id' => $company_id,
                'user_id' => $user_id
            ],
            [
                'updated_at' => now(),
                'created_at' => now()
            ]
        );  
        
        $company->update($request->all());

        // Sync users if provided
        if ($request->has('user_ids') && is_array($request->user_ids)) {
            $company->clients()->sync($request->user_ids);
        }

        return response()->json([
            "message"=>200,
            "company"=>$company
        ]);
    }
    public function removeEmployee(Request $request, $id)
    {
        $user_id = $request->user_id;
        $company_id = $request->company_id;

        DB::table('company_users')
            ->where('company_id', $company_id)
            ->where('user_id', $user_id)
            ->delete();

        return response()->json([
            "message" => 200,
        ]);
    }

    public function usersbyCompany(Request $request, $company_id)
    {
        $company = Company::with(['users'])->findOrFail($company_id);
      

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'company' => $company,
        ], 200);
    }
}
