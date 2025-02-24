<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json(['message' => 'Data berhasil diambil!', 'data' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        return response()->json(['message' => 'Data customer berhasil disimpan!', 'data' => $customer], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customerDetail = Customer::findOrFail($id);
        return response()->json(['message' => 'Detail customer berhasil diambil!', 'data' => $customerDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customerUpdate = Customer::findOrFail($id);
        $customerUpdate->update($request->all());

        return response()->json(['message' => 'Customer berhasil diupdate!', 'data' => $customerUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::findOrFail($id)->delete();
        return response()->json(['message' => 'Customer berhasil dihapus!'], 204);
    }
}