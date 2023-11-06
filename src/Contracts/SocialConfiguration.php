<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\DTO\UserInformationDTO;
use Cornatul\Social\Models\SocialAccountConfiguration;

interface SocialConfiguration
{
    public function getAccountConfiguration(int $account, string $provider): ConfigurationDTO;

    public function saveAccountInformation(UserInformationDTO $userInformationDTO): bool;

}
