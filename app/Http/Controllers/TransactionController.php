<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Basket;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ApiIndex()
    {
        try{
            // $transactions = DB::table('transactions')->join('transaction_item','transactions.id','=','transaction_item.transaction_id')->select('transactions.*','transaction_item.*')->get();
            $transactions = Transaction::All();
            $data  = [];
            foreach($transactions as $transaction){
                $data[]=[

                ];
            }
            return response()->json($transaction);
        }catch(Eception $e){

        }
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
            $user_id=Auth::id();
            $basket=Basket::where('user_id','=',$user_id)->firstOrFail();
            $item_id = $basket->items()->pluck('item_id')->toArray();
            $new_transaction = new Transaction();
            $new_transaction->total_balance = $request->get('totalBalance');
            $new_transaction->id_user=$user_id;
            $new_transaction->save();

            $new_transaction->items()->attach($item_id);
            $message = [
                'status'=> 200,
                'message'=>'success',
                'item_id'=>$item_id,
            ];
        }catch(Exception $e){
            $message = [
                'status'=> 500,
                'message'=>'internal server error',
            ];
            return response()->json($message);
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
