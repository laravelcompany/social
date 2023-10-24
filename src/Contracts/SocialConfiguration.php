<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\Models\SocialAccountConfiguration;

interface SocialConfiguration
{
    public function getAccountConfiguration(int $account): SocialAccountConfiguration;

}
