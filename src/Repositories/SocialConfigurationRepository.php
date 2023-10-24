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
 */
class SocialConfigurationRepository implements SocialConfiguration
{
    public final function getAccountConfiguration(int $account): SocialAccountConfiguration
    {
        return SocialAccountConfiguration::find($account);
    }
}
