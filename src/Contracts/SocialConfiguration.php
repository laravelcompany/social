<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\Models\SocialAccountConfiguration;

interface SocialConfiguration
{
    public function getAccountConfiguration(int $account, string $provider): ConfigurationDTO;

}
