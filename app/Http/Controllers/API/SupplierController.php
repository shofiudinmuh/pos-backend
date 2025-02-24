<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json(['message' => 'Data supplier berhasil diambil', 'data' => $suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supplier = Supplier::create($request->all());
        return response()->json(['message' => 'Supplier berhasil disimpan!', 'data' => $supplier], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplierDetail = Supplier::findOrFail($id);
        return response()->json(['message' => 'Detail supplier berhasil diambil!', 'data' => $supplierDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplierUpdate = Supplier::findOrFail($id);
        $supplierUpdate->update($request->all());

        return response()->json(['message' => 'Supplier berhasil diupdate!', 'data' => $supplierUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::findOrFail($id)->delete();
        return response()->json(['message' => 'Supplier berhasil dihapus!'], 204);
    }
}