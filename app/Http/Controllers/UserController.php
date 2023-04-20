<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\User\UserStoreRequest;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:user-view', ['only' => ['index']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-store', ['only' => ['store']]);
        $this->middleware('permission:user-update', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    
    public function store(UserStoreRequest $request)
    {

        $validated = $request->validated();
        $user = User::create($validated);

        if($request->input('permissions')) {
            foreach($request->input('permissions') as $permission) {
                $user->givePermissionTo($permission);
            }
        }

        if($request->input('roles')) {
            foreach($request->input('roles') as $role) {
                $user->assignRole($role);
            }
        }

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }
    
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
