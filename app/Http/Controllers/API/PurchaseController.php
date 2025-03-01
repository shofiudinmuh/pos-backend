<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('details.product', 'supplier')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data acquired successfully!',
            'data' => $purchases
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'purchase_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try{
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'total_amount' => $request->total_amount,
                'purchase_date' => $request->purchase_date
            ]);

            foreach($request->items as $item){
                PurchaseDetail::create([
                    'purchase_id' => $purchase->purchase_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'sub_total' => $item['price'] * $item['quantity']
                ]);
            }

            DB::commit();

            return response()->json($purchase->load(['details.product', 'supplier']), 201);

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
        $purchase = Purchase::with('details.product', 'supplier')->find($id);
        if(!$purchase){
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail purchase acquired successfully!',
            'data' => $purchase
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'purchase_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try{
            $purchase = Purchase::find($id);

            if(!$purchase){
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase not found!'
                ], 404);
            }

            $purchase->update(
                $request->only([
                    'supplier_id',
                    'total_amount',
                    'purchase_date'
                ])
                );
            
                if($request->has('items')){
                    $purchase->details()->delete();

                    foreach($request->items as $item){
                        PurchaseDetail::create([
                            'purchase_id' => $purchase->purchase_id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'sub_total' => $item['quantity'] * $item['price'],
                        ]);
                    }
                }
                DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try{
            $purchase = Purchase::find($id);

            if(!$purchase){
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase not found!'
                ], 404);
            }

            $purchase->details()->delete();

            $purchase->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase deleted successfully!'
            ]);
        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}