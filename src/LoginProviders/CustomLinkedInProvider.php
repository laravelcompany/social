<?php

namespace Cornatul\Social\LoginProviders;

use GuzzleHttp\RequestOptions;
use Laravel\Socialite\Two\LinkedInProvider;
use Laravel\Socialite\Two\User;

class CustomLinkedInProvider extends LinkedInProvider
{
    public $scopes = ["profile","w_member_social", "openid", "email"];

    private string $projections = '(sub,name,picture,given_name,family_name,email,locale,email_verified)';

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
                'projection' => $this->projections,
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
            'id' => $user['sub'] ?? "",
            'name' => $user['name'] ?? "",
            'last_name' => $user['given_name'] ?? "",
            'email' => $user['email'] ?? "",
            'avatar' => $user['picture'] ?? "",
        ]);
    }
}
