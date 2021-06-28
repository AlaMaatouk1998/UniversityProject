<?php

namespace App\Resolvers;

use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;
use App\LinkedSocialAccount;
class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        $user = Socialite::driver($provider)->userFromToken($accessToken);
        $exist = LinkedSocialAccount::where('provider_name',  $provider)->where('provider_id', $user->getId())->first();
        return ($exist->user);
    }
}

