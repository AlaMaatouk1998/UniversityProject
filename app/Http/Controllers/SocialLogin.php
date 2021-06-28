<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\LinkedSocialAccount;
use App\User;
use Socialite;
use Illuminate\Support\Facades\Route;
class SocialLogin extends Controller {

	public function loginGoogle(Request $request) {
		try {
            
            $google = Socialite::driver('google')->stateless()->user();
            
            if(!$exist = LinkedSocialAccount::where('provider_name',  'google')->where('provider_id', $google->getId())->first()){
                $user = new User();
                $user->name = $google->getName();
                $user->email = $google->getEmail();
                $user->save();

				$account = new LinkedSocialAccount();
                $account->provider_id = $google->getId();
                $account->provider_name = 'google';
                $account->user_id = $user->id;
                $account->save();
			}

			return;
		}
		catch(\Exception $e) {
			return response()->json([ "error" => $e->getMessage() ]);
		}
		
	}
}