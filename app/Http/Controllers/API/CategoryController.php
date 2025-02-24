<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json(['message' => 'Data kategori berhasil diambil!', 'data' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return response()->json(['message' => 'Categori berhasil disimpan!', 'data' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoryDetail = Category::findOrFail($id);
        return response()->json(['message' => 'Detail kategori berhasil diambil!', 'data' => $categoryDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoryUpdate = Category::findOrFail($id);
        $categoryUpdate->update($request->all());
        return response()->json(['message' => 'Kategori berhasil diupdate!', 'data' => $categoryUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus!'], 204);
    }
}