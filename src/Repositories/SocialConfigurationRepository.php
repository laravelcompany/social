<?php

namespace Cornatul\Social\Repositories;

use Cornatul\Social\Contracts\SocialConfiguration;
use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Service\SocialOauthService;
use Illuminate\Database\QueryException;
use League\OAuth2\Client\Provider\LinkedIn;
use Smolblog\OAuth2\Client\Provider\Twitter;
use RuntimeException;

/**
 * @todo This is not yet being used but we can used
 */
class SocialConfigurationRepository implements SocialConfiguration
{
    /**
     * @throws \RuntimeException
     */
    public final function getAccountConfiguration(int $account,string $type): ConfigurationDTO
    {
        $data = SocialAccountConfiguration::where('social_account_id', $account)->where('type', $type)->first();

        if (!$data) {
            throw new \RuntimeException("Account with id {$account} not found in the database");
        }

        return ConfigurationDTO::from($data);
    }

    public final function saveAccountInformation(array $data):bool
    {

        $account = request()->session()->get('account');

        $provider = request()->session()->get('provider');

        $credentials = SocialAccountConfiguration::where('social_account_id', $account)
            ->where('type', $provider)
            ->first();

        $credentials->information = json_encode($data);

        return $credentials->save();

    }
}
