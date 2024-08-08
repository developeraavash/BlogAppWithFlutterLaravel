<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {

        //validate the feilds of the

        $validate = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        // Create a new user
        $user = User::create(
            [
                'name' => $validate['name'],
                'email' => $validate['email'],
                'password' => bcrypt($validate['password'])
            ]
        );


        return response(
            [
                'user' => $user,
                'token' => $user->createToken('secret')->plainTextToken,
            ]
        );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {

        //validate the feilds of the

        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|',
        ]);
        if (!Auth::attempt($validate)) {
            return response([
                'message' => 'Invalid username or password'
            ], 403);
        }

        return response(
            [
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('secret')->plainTextToken,
            ],
            200
        );

    }



    // Logout

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logged out successfully'

        ], 200);

    }



    // get user details
    public function user()
    {
        return response(
            [
                'user' => auth()->user()
            ],
            200
        );

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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
