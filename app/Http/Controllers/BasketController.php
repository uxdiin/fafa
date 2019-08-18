<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Basket;
use App\User;
use Mockery\CountValidator\Exception;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function countBasketItem(){
        $user_id = Auth::id();
        $count = DB::select("select count(basket_id) as count from baskets join basket_item on baskets.id=basket_item.basket_id where baskets.user_id ='$user_id'");
        return response()->json($count);
    }
    public function apiIndex(){

            $user_id = Auth::id();
            $baskets = DB::select("select * from baskets join basket_item on baskets.id=basket_item.basket_id join items on basket_item.item_id=items.id where user_id='$user_id'");
            $data = [];
            $index = 0;
            foreach($baskets as $basket){

                $data[] = [
                    'id'=>$basket->id,
                    'user_id'=>$basket->user_id,
                    'item_id'=>$basket->item_id,
                    'name'=>$basket->name,
                    'photo'=>$basket->photo,
                    'price'=>$basket->price,
                    'total'=>$basket->total,
                    'action'=>'<a class="btn btn-outline-primary round" onclick="decTotal('.$index.')">-</a><input type="text" readonly class="col-4" name="total" value="'.$basket->total.'" style="border:0"><a class ="btn btn-outline-primary round" onclick="addTotal('.$index.')">+</a>',
                ];
                $index++;
            }
            $message = [
                'status' => 200,
                'message' => 'sukses',
            ];

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
    public static function store()
    {
        try{
            $user_id=Auth::id();
            $Basket = new Basket();
            $Basket->user_id=$user_id;
            $Basket->save();
        }catch(Exception $e){

        }
        return redirect()->route('home.index');
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
    public function edit()
    {

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
            $user_id=Auth::id();
            $baskets = DB::select("select id from baskets where user_id = '$user_id' limit 1");
            foreach ($baskets as $key){
                $id=$key->id;
            }
            $basket = Basket::findOrFail($id);
            $item_id = $request->get('item_id');
            $counts = DB::select("select count(baskets.id) as count from baskets join basket_item on baskets.id=basket_item.basket_id where baskets.user_id ='$user_id' and item_id='$item_id'");
            $total_items = DB::select("select total as total,item_id from baskets join basket_item on baskets.id=basket_item.basket_id where baskets.user_id ='$user_id' and item_id='$item_id'");
            $total=0;
            foreach($counts as $count){
                $counte = $count->count;
            }

            if($counte == 0){
                $total = 1;
                $basket->items()->attach(['item_id'=>$item_id],['total'=>$total]);
                $message=[
                    'status'=>200,
                    'message'=>'sukses',
                ];
                }else{
                foreach($total_items as $total_item){
                    $total = $total_item->total;
                    // $item_id = $total_item->item_id;
                }
                $total++;
                $basket->items()->sync([$item_id=>['total'=>$total]],false);
                $message = [
                    'status'=>200,
                    'message' => 'success add count'
                ];
            }
        }catch(Exception $e){
            $message=[
                'status'=>500,
                'message'=>'internal server error',
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
    public function destroy($id)
    {
        //
    }
    public function addTotal(Request $request){
        $item_id = $request->get('item_id');
        $user_id = Auth::id();
        $baskets = DB::select("select id from baskets where user_id = '$user_id' limit 1");
        foreach ($baskets as $key){
            $id=$key->id;
        }
        $basket = Basket::findOrFail($id);
        $total_items = DB::select("select total ,item_id from baskets join basket_item on baskets.id=basket_item.basket_id where baskets.user_id ='$user_id' and item_id='$item_id'");
        foreach($total_items as $total_item){
            $total = $total_item->total;
            // $item_id = $total_item->item_id;
        }
        $total++;
        $basket->items()->sync([$item_id=>['total'=>$total]],false);
        $message = [
            'status'=>200,
            'message' => 'success add count'
        ];
        return response()->json($message);
    }
    public function decTotal(Request $request){
        $item_id = $request->get('item_id');
        $user_id = Auth::id();
        $baskets = DB::select("select id from baskets where user_id = '$user_id' limit 1");
        foreach ($baskets as $key){
            $id=$key->id;
        }
        $basket = Basket::findOrFail($id);
        $total_items = DB::select("select total ,item_id from baskets join basket_item on baskets.id=basket_item.basket_id where baskets.user_id ='$user_id' and item_id='$item_id'");
        foreach($total_items as $total_item){
            $total = $total_item->total;
            // $item_id = $total_item->item_id;
        }
        $total--;
        $basket->items()->sync([$item_id=>['total'=>$total]],false);
        $message = [
            'status'=>200,
            'message' => 'success add count'
        ];
        return response()->json($message);
    }
}
