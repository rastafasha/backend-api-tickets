<?php

namespace App\Http\Controllers;

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
        $search = $request->search;

        $companies = Company::orderBy("id", "desc")
        ->get();
                    
        return response()->json([
            "companies" => $companies,
            
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

        $user_id = $request->user_id;

        if ($user_id) {
            DB::table('companies_users')->updateOrInsert(
                [
                    'company_id' => $company->id,
                    'user_id' => $user_id
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }

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
            "company" => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function updateCompany(Request $request, $id)
    {

        $company = Company::findOrFail($id);
        if($request->hasFile('avatar')){
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
}
