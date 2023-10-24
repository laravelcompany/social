<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\Models\SocialAccount;

interface SocialContract
{
    public function createAccount(string $name, int $userId): SocialAccount;
}
