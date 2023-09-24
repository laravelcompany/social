<?php

namespace Cornatul\Social\Repositories;

use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Service\SocialOauthService;
use Illuminate\Database\QueryException;
use League\OAuth2\Client\Provider\LinkedIn;
use League\OAuth2\Client\Provider\Twitter;
use RuntimeException;

class SocialRepository
{

    private const ACCOUNT_TWITTER = 'twitter';
    private const ACCOUNT_LINKEDIN = 'linkedin';
    private const ACCOUNT_FACEBOOK = 'facebook';

    private $providerClasses = [
        self::ACCOUNT_TWITTER => Twitter::class,
        self::ACCOUNT_LINKEDIN => LinkedIn::class,
        // Add other account types here if needed
    ];

    /**
     * @throws \Exception
     */
    public final function getSocialService(int $account): SocialOauthService
    {
        $data = SocialAccountConfiguration::find($account);

        $credentials = ConfigurationDTO::from($data->configuration);

        if (!$credentials) {
            throw new QueryException("Account with id {$account} not found in the database");
        }

        $providerClass = $this->providerClasses[$data->type] ?? null;

        if (!$providerClass) {
            throw new RuntimeException("This type of service is not supported");
        }

        $provider = new $providerClass($credentials->toArray());

        return new SocialOauthService($provider);
    }

    /**
     * @throws \Exception
     */
    public function getAccountFromSession(): int
    {
        $account = session()->get('account');

        if (!$account) {
            throw new \Exception("Account not found in session");
        }

        return $account;
    }


    public final function saveAccountInformation(ConfigurationDTO $configurationDTO, int $account): void
    {
        $data = SocialAccountConfiguration::find($account);

        if (!$data) {
            throw new QueryException("Account with id {$account} not found in the database");
        }

        $data->information = $configurationDTO->toJson();
        $data->save();
    }
}
