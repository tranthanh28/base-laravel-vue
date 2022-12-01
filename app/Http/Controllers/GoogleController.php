<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    /**
     * Create a new controller instance.
     *
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            if(!str_contains($user->email, '@manhinhcong')) {
                return response()->json([
                    'success' => false,
                    'message' => "Only accept email: @manhinhcong"
                ]);
            }

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                $token = $finduser->createToken("API TOKEN")->plainTextToken;
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);
                $token = $newUser->createToken("API TOKEN")->plainTextToken;
            }

            return view('callback', [
                'token' => $token,
            ]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
