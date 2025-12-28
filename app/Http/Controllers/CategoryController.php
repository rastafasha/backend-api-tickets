<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Evento;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los categories',
            'categories' => $categories,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categoryStore(Request $request)
    {
        // return Category::create($request->all());

        $category = Category::create($request->all());

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
    public function categoryShow($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            "category" => $category,
            
        ]);
    }
    public function categoryEvents(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category_id = $category->id;
        $events = Evento::where('category_id', $category_id)
        ->where('status',  'PUBLISHED')
        ->get();

        return response()->json([
            "category" => $category,
            "events" => $events,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryUpdate(Request $request, $id)
    {
        
       $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json([
            "message"=>200,
            "category"=>$category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryDestroy($id)
    {
        $category = Category::findOrFail($id);
        
        $category->delete();
        return response()->json([
            "message"=>200
        ]);
    }

    public function search(Request $request){
        return Category::search($request->buscar);
    }
}
