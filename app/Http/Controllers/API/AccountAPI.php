<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;



class AccountAPI extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), 
        [
            'name' =>'required|string|max:50',
            'email' =>'required|email',
            'password' =>'required|string|min:6',
            'phone' =>'required',
            'profile_image' =>'nullable|image',
            'date_of_birth' =>'nullable',
            'nationality' =>'nullable',
            'status' => 'nullable|in:idle,online,offline',
            'role' => 'nullable|in:user,technician',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'profile_image' => $request->file('profile_image') ? $request->file('profile_image')->store('profile_images', 'public') : null,
            'status' => $request->status ?? 'online',
            'role' => $request->role ??'user',
        ]);
        $success['token'] = $user->createToken('Token')->plainTextToken;
        $success['message'] =  $user;
        return response()->json($success, 201);

    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (Auth::user()->id !==$user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }         
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:50',
            'profile_image' => 'nullable|image|max:4096',
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'profile_image' => $request->file('profile_image') ? $request->file('profile_image')->store('profile_images', 'public') : $user->profile_image,
        ]);

        return response()->json(['Update Success!', $user], 200);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id !==$user->id) 
    {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
        return response()->json($user);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            $success['token'] = $admin->createToken('AdminToken')->plainTextToken;
            $success['name'] = $admin->name;
            return response()->json(['success' => $success], 200);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Token')->plainTextToken;
            $success['name'] = $user->name;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    
    public function logout(Request $request): JsonResponse
    {
        if ($request->user('sanctum') instanceof \App\Models\Admin) {
            $admin = $request->user('sanctum');
            if ($admin) {
            $admin->currentAccessToken()->delete();
            return response()->json(['success' => 'Logged out successfully', 'id' => $admin->id, 'name' => $admin->name], 200);
            } else {
            return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        $user = $request->user('sanctum');
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json(['success' => 'Logged out successfully', 'id' => $user->id, 'name' => $user->name,], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
