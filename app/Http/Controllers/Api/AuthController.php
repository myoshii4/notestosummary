<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller

{
    public function register(NoteRequest $request)
    {
        $user = $request->validated();
        $user = User::create();


        return $user;
    }

    public function login(NoteRequest $request)
    {
    $request->validate([
            'email'     =>  'required|string|email|max:255',
            'password'  =>  'required',
        ]);
 
        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) 
        {
            throw ValidationException::withMessages(
            [
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $response = [
            'user'  =>  $user,
            'token' =>  $user->createToken($request->email)->plainTextToken
        ];
    
        return response($response,200);
    }

    
    public function logout(NoteRequest $request)
    {
        $request->user()->tokens()->delete();

       $response = [
            'message' => 'Logout.'
       ];

        return $response;
    }

    //Store all signup information.
    public function store(NoteRequest $request)
    {
        
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return $user;
    }


    //Sign-in Email
    public function email(NoteRequest $request, string $id)
    {
        $user = User::findorFail($id);

        $validated = $request->validated();

        $user->email = $validated['email'];

        $user->save();

        return $user;
    }

    //Sign-in Password 
    public function password(NoteRequest $request, string $id)
    {
        $user = User::findorFail($id);

        $validated = $request->validated();

        $user->password = Hash::make($validated['password']);

        $user->save();

        return $user;
    }

    public function update(Request $request, string $id)
    {
        $user = User::findorFail($id);
        $user->update($user);
        

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findorFail($id);

        $user->delete();

        return $user;
    }
}
