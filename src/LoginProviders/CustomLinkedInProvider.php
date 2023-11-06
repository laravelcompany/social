<?php

namespace Cornatul\Social\LoginProviders;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\User;

class CustomLinkedInProvider extends \Laravel\Socialite\Two\LinkedInProvider
{
    public $scopes = ["profile","w_member_social", "openid", "email"];

    public final function getUserByToken($token):array
    {
        return $this->getBasicProfile($token);
    }

    public final function getBasicProfile($token): array
    {
        $response = $this->getHttpClient()->get('https://api.linkedin.com/v2/userinfo', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
                'X-RestLi-Protocol-Version' => '2.0.0',
            ],
            RequestOptions::QUERY => [
                'projection' => '(sub,name,picture,given_name,family_name,email,locale,email_verified)',
            ],
        ]);

        return (array) json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    public final function mapUserToObject(array $user):User
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['sub'],
            'nickname' => null,
            'name' => $user['name'],
            'first_name' => $user['name'],
            'last_name' => $user['given_name'],
            'email' => $user['email'] ?? null,
            'avatar' => $user['picture'],
            'avatar_original' => "",
        ]);
    }
}
