<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Adresse;
use App\Gouvernorat;
class AuthController extends Controller
{
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
        ]);
        try{
            // $adresse = new Adresse();
            // $adresse->adresse = $request->adresse['adresse'];
            // $adresse->gouvernorat = $request->gouvernorat;
            // $adresse->gouvernorat_id = 1; //Gouvernorat::where('nom', $request->gouvernorat)->first()->id;
            // $adresse->save();
            // $role = 0;
            // if($request->role){
            //     if($request->role == 'Teleoperateur'){
            //         $role = 0;
            //     }
            //     if($request->role == 'UTSS'){
            //         $role = 1;
            //     }
            //     if($request->role == 'CRRC'){
            //         $role = 2;
            //     }
            //     if($request->role == 'Admin_Ministere'){
            //         $role = 3;
            //     }
            // }
            return User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'telephone' => $request->telephone,
                'adresse_id' => $request->adresse_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
        }catch(Exception $e){
            return response()->json($e->getMessage(), $e->getHttpStatus());
        }
        return response()->json('Requete invalide', 400);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }

}
