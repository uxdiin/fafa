<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalPrice(){
        $user_id = Auth::id();
        $total_price = DB::select("select sum(total*price) as total_price from baskets join basket_item on baskets.id=basket_item.basket_id join items on basket_item.item_id=items.id where user_id=$user_id");
        return $total_price;
    }
    public function totalBalance(Request $request){
        $totalPrices = $this->totalPrice();
        $totalPrice = (int)$totalPrices[0]->total_price;
        $service_id = $request->get('service_id');
        $sc = new ShippingController();
        $shippingPrices = $sc->price($request);
        // foreach($shippingPrices as $shippingPrice){
        //     foreach()
        // }
        $shippingPrice = $shippingPrices->original[0]->costs[$service_id]->cost[0]->value;
        $totalBalance = $totalPrice + $shippingPrice;
        return $totalBalance;
    }
    public function getTotalBalance(Request $request){
        return response()->json($this->totalBalance($request));
    }
    public function makeOrder(Request $request){
        try{
            $totalBalance = $this->totalBalance($request);
            $request->request->add(['totalBalance'=>$totalBalance]);
            $TC= new TransactionController();
            // $TC->store($request);
            $message = [
                'status'=>200,
                'message'=>'sukses'
            ];
        }catch(Exception $e){
            $message = [
                'status'=>500,
                'message'=>'internal server error'
            ];

            return response()->json($message);
        }
        return $TC->store($request);
        
    }
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
