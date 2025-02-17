<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'User registered successfully' ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

         $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|unique:users',
            'password' => 'nullable|string|min:8|confirmed'
        ]);
        $data = [
            'name' => $request->name,
        ];
        if ($request->filled('email') && $request->email !== $user->email) {
            $data['email'] = $request->email;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , string $id)
    {
        if($request->user()->tokenCan('full access')){
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function role()
    {
        if(auth()->user()->abilities()[0] != 'full access'){
            return response()->json(['message' => 'You do not have full access'], 401);
        }
        $roles = Role::all();
        return response()->json(['message' => 'Roles',$roles], 200);
    }

    public function assignRole(Request $request)
    {
        $abilities = auth()->user()->abilities()->toArray();
        if($abilities[0] != 'full access'){
            return response()->json(['message' => 'You do not have full access'], 401);
        }
        $request->validate([
            'role_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        return response()->json(['message' => 'Role assigned successfully'], 200);
    }
}
