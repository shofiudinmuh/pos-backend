<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::all();
        return response()->json(['message' => 'Data inventori berhasil diambil!', 'data' => $inventories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inventory = Inventory::create($request->all());
        return response()->json(['message' => 'Inventory berhasil disimpan!', 'data' => $inventory], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventoryDetail = Inventory::findOrFail($id);
        return response()->json(['message' => 'Detail inventori berhasil diambil!', 'data' => $inventoryDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventoryUpdate = Inventory::findOrFail($id);
        $inventoryUpdate->update($request->all());
        return response()->json(['message' => 'Inventory berhasil diupdate!', 'data' => $inventoryUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Inventory::findOrFail($id)->delete();
        return response()->json(['message' => 'Inventori berhasil dihapus!'], 204);
    }
}