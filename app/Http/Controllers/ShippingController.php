<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function api($prov){
        $curl = curl_init();
        // $prov = "https://api.rajaongkir.com/starter/province";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $prov,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 46bc26789ae61e0844440e811cd8886e"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response);
        $data = $data->rajaongkir->results;
        if ($err) {

        } else {
            return response()->json($data);
        }
    }
    public static function api2($from,$city_id,$weight,$courier){
        $curl = curl_init();
        // $prov = "https://api.rajaongkir.com/starter/province";

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$from&destination=$city_id&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "key: 46bc26789ae61e0844440e811cd8886e"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response);
        $data = $data->rajaongkir->results;
        if ($err) {

        } else {
            return response()->json($data);
        }
    }
    public function listProvince(){
        $prov = "https://api.rajaongkir.com/starter/province";
        return ShippingController::api($prov);
    }
    public function listCity(Request $request){
        $city = "https://api.rajaongkir.com/starter/city?&province=$request->province_id";
        return ShippingController::api($city);
    }
    public function price(Request $request){
        $from = 66;
        $user_id = Auth::id();
        $baskets = DB::select("select * from baskets join basket_item on baskets.id=basket_item.basket_id join items on basket_item.item_id=items.id where user_id='$user_id'");
        $courier ="jne";
        $totalWeight = 0 ;
        foreach($baskets as $basket){
                $totalWeight=$totalWeight+$basket->total*$basket->weight;
        }
        return ShippingController::api2($from,$request->city_id,$totalWeight,$courier);
    }
    public function index()
    {
        //
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
