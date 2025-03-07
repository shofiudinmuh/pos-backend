<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Data users berhasil diambil!', 'data' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'string|255|required',
            'email' => 'string|255|requred|unique',
            'password' => 'string|required'
        ]);
        $roles = 2;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'roles' => $roles
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'string|255|required',
            'email' => 'string|255|requred|unique',
            'password' => 'string|required',
            'roles' => 'integer|required'
        ]);

        $user = User::update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'roles' => $request->roles
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'User deleted failed!'
            ], 500);
        }
    }
}