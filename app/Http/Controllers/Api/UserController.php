<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('is_admin', false)->get([
            'id', 'name', 'email', 'created_at'
        ]);

        if (count($users) == 0) {
            return response()->json([
                'message' => 'No users found',
                'users' => []
            ]);
        }
        
        return response()->json([
            'message' => 'User listed',
            'users' => $users,
        ]);

    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email:filter|unique:users,email',
            'password' => 'required|string|min:5',
            'password_confirm' => 'required_with:password|min:5|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'New user created',
            'data' => $user,
        ]);
    }

    public function update(Request $request, int $userId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email:filter',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('id', $userId)->first();
        if (! $user) {
            return response()->json([
                'message' => "User not found with id:{$userId}",
            ], 404);
        }

        if (User::where('email', $request->email)->where('id', '<>', $userId)->count()) {
            return response()->json([
                'message' => "email exist by another user",
            ]);
        }
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'User updated',
            'data' => $user,
        ]);
    }

    public function detail(Request $request, int $userId)
    {
        $user = User::where('id', $userId)->where('is_admin', false)->first();
        if (! $user) {
            return response()->json([
                'message' => "User not found with id:{$userId}",
            ], 404);
        }

        return response()->json([
            'message' => 'User detail',
            'data' => $user,
        ]);
    }

    public function destroy(Request $request, int $userId)
    {
        $user = User::where('id', $userId)->first();
        if (! $user) {
            return response()->json([
                'message' => "User not found with id:{$userId}",
            ], 404);
        }
        
        $user->delete();

        return response()->json([
            'message' => 'User deleted',
            // 'data' => $user,
        ]);
    }
}
