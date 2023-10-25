<?php

namespace Cornatul\Social\Service;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SocialOauthService
{
    private AbstractProvider $provider;

    public function __construct(AbstractProvider $provider)
    {
        $this->provider = $provider;
    }

    public final function getAuthUrl(array $scopes)
    {
        //todo add scopes here using the id
        $options = [
            'state' => bin2hex(random_bytes(16)),
            'scope' => $scopes,
        ];

        return $this->provider->getAuthorizationUrl($options);
    }

    /**
     * @throws IdentityProviderException
     */
    public final function getAccessToken(string $code, string $code_verifier=''): AccessTokenInterface
    {
        return $this->provider->getAccessToken('authorization_code', [
            'code' => $code,
            'code_verifier' => $code_verifier,
        ]);
    }

    public final function getProfile(AccessToken $accessToken): ResourceOwnerInterface
    {
            return $this->provider->getResourceOwner($accessToken);
    }
}
