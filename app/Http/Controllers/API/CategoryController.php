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
        return response()->json([
            'success' => true,
            'message' => 'Categori berhasil disimpan!', 
            'data' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoryDetail = Category::findOrFail($id);
        return response()->json(['message' => 'Details of categories acquired!', 'data' => $categoryDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if (empty($id)) {
        return response()->json([
            'success' => false,
            'message' => 'category_id tidak diterima!',
        ], 400);
    }
    
        $categoryUpdate = Category::findOrFail($id);
        // $categoryUpdate = Category::where('category_id', $id);

        if(!$categoryUpdate){
            return response()->json([
                'success' => false,
                'message' => 'Categories not found!',
            ], 404);
        }
        
        $categoryUpdate->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate!', 
            'data' => $categoryUpdate]);
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