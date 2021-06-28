<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\LinkedSocialAccount;
use Socialite;
class AuthController extends Controller
{
    public function socialLogin(Request $request){
     
        $request->request->add([
			'grant_type' => 'social',
			'client_id' => config('services.passport.client_id'), // it should be password grant client
			'client_secret' => config('services.passport.client_secret'),
			'access_token' => $request->accessToken, // access token from provider
			'provider' => $request->provider, // i.e. google
        ]);
        try{
            $tokenRequest = Request::create(
                config('services.passport.login_endpoint'),
                'post'
            );
            $response = Route::dispatch($tokenRequest);
        }catch(\Exception $e) {
			return response()->json([ "error" => $e->getMessage() ]);
        }
        
        return $response;
    }

    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic 
        $socialUser = Socialite::driver($provider)->stateless()->user();

        if(!$exist = LinkedSocialAccount::where('provider_name',  $provider)->where('provider_id', $socialUser->getId())->first()){
            $user = new User();
            $user->name = $socialUser->getName();
            $user->email = $socialUser->getEmail();
            $user->save();

            $account = new LinkedSocialAccount();
            $account->provider_id = $socialUser->getId();
            $account->provider_name = $provider;
            $account->user_id = $user->id;
            $account->save();
        }
 
        return response()->json($socialUser);
    }


    public function login(Request $request)
    {
        $email = $request->username;
        $password = $request->password;
        $request->request->add([
            'username' => $email,
            'password' => $password,
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
        ]);

        $tokenRequest = Request::create(
            config('services.passport.login_endpoint'),
            'post'
        );
        $response = Route::dispatch($tokenRequest);

        if($response->getStatusCode() == 200){
            return $response;
        }else {
            return response()->json('Invalid Request. Please enter a username or a password.', $response->getStatusCode());
        }

        return $response;
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
