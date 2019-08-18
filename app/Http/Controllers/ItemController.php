<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::All();
        return view('items.index',['categories'=>$categories]);
    }
    public function apiIndex(){
        $items = Item::orderBy('id', 'desc')->get();
        // $categories = Items>Category()->name;
        $data = [];
        $nameCategories =[];

        foreach ($items as $key) {
            # code...
            $number = 1;
            foreach ($key->categories as $category){
                $nameCategories[$number] = $category->name;
                $number++;
            }
            $data[] = [
                'id' => $key->id,
                'name' => $key->name,
                'price' => $key->price,
                'photo' => $key->photo,
                'weight' => $key->weight,
                'stock' => $key->stock,
                'categories' => $nameCategories,
                'action' => '<a class="btn btn-outline-success btn-sm btn-edit" data-toggle="modal" style="border-radius:24px" data-target="#myModal">Edit/Show</a><a class="btn btn-outline-danger btn-sm btn-destroy" style="border-radius:24px">Hapus</a>'
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-item');
        // if(Gate::denies('create-item')){
        //     abort(403);
        // }
        try{
            $new_item = new Item();
            $new_item->name = $request->get('name');
            $new_item->price = $request->get('price');
            $new_item->weight = $request->get('weight');
            $new_item->stock = $request->get('stock');
            if($request->file('photo')){
                $file = $request->file('photo')->store('item_photos','public');
                $new_item->photo = $file;
            }
            $new_item->save();
            $new_item->categories()->attach($request->get('categories'));
            $message=[
                'status'=>200,
                'message'=>"data berhasil di simpan",
            ];
        }catch(Exception $e){
            $message=[
                'status'=>500,
                'message'=>"data gagal di simpan",
            ];
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
            $id=$request->get('id');
            $update_item = Item::findOrfail($id);
            $update_item->name = $request->get('update_name');
            $update_item->price = $request->get('update_price');
            $update_item->weight = $request->get('weight');
            $update_item->stock = $request->get('stock');

            if($request->file('update_photo')){
                $file = $request->file('update_photo')->store('item_photos','public');
                $update_item->photo = $file;
            }
            $update_item->save();
            $update_item->categories()->attach($request->get('categories'));
            $message=[
                'status'=>200,
                'message'=>"data berhasil di simpan",
            ];
        }catch(Exception $e){
            $message=[
                'status'=>500,
                'message'=>"data gagal di simpan",
            ];
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
        try {
            $id = $request->get('id');
            $item = Item::findOrFail($id);
            $item->delete();
            $message = [
                'status' => 200,
                'message' => 'data berhasil dihapus',
            ];
        } catch (Exception $e) {
            $message = [
                'status' => 500,
                'message' => 'data gagal dihapus',
            ];
        }
        return response()->json($message);
    }
}
