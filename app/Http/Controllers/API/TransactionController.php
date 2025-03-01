<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('details.product')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil!',
            'data' => $transactions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'integer',
            'user_id' => 'required | integer',
            'total_amount' => 'required | numeric',
            'total_tax' => 'nullable | numeric',
            'total_discount' => 'nullable | numeric',
            'final_amount' => 'required | numeric',
            'payment_method' => 'required | in:cash,debit,credit,e-wallet',
            'products' => 'required | array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity' => 'requred|integer',
            'products.*.price' => 'required|numeric',
            'products.*.discount' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try{
            $transaction = Transaction::create([
                'customer_id' =>$request->customer_id,
                'user_id' => $request->user_id,
                'total_amount' => $request->total_amount,
                'total_tax' => $request->total_tax,
                'total_discount' => $request->total_discount,
                'final_amount' => $request->final_amount,
                'payment_method' =>$request->payment_method
            ]);

            foreach($request->products as $product){
                TransactionDetail::create([
                    'transaction_id' => $transaction->transaction_id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0,
                    'sub_total' => ($product['price'] - $product['discount'] * $product['quantity'])
                ]);
            }

            DB::commit();

            return response()->json($transactions->load('details.product'), 201);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with('details.product')->find($id);
        if(!$transaction){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Transaction not found!'
                ], 404
            );
        }
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $transaction = Transaction::find($id);
        if(!$transaction){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Transaction not found!'
                ], 404
            );
        }
        DB::beginTransaction();
        try{
            $transaction->details()->delete();
            $transaction->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully!'
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 
            500);
        }
    }
}