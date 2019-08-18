<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }
    public function apiIndex()
    {
        $categories = Category::All();
        $data = [];
        foreach($categories as $category){
            $data[] = [
                'id'=> $category->id,
                'name' => $category->name,
                'action' => '<a class="btn btn-outline-success btn-sm btn-edit" data-toggle="modal" style="border-radius:24px" data-target="#myModal">Edit/Show</a><a class="btn btn-outline-danger btn-sm btn-destroy" style="border-radius:24px" onClick="destroy()">Hapus</a>'
            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $new_catgeory = new Category();
            $new_catgeory->name = $request->name;
            $new_catgeory->save();
            $message = [
                'status'=>200,
                'message'=>"sukses",
            ];
        }catch(Exception $e){

        }
            return response()->json($message);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request)
    {
        try{
            $update_category = Category::findOrFail($request->get('id'));
            $update_category->name = $request->get('update_name');
            $update_category->save();
            $message=[
                'status'=> 200,
                'message' => 'sukses',
            ];
        }catch(Exception $e){
            $message=[
                'status'=> 500,
                'message' => 'internal server error',
            ];
            return response()->json($message);
        }
            return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $category = Category::findOrFail($id);
        $category->delete();
        $message=[
            'status'=> 200,
            'message' => 'sukses',
        ];
        return response()->json($message);
    }
}
