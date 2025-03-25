<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\Models\SocialAccount;

interface SocialContract
{
    public function createAccount(string $name, int $userId): SocialAccount;
    public function getAccount(int $id): SocialAccount;

    public function updateAccount(int $id, string $name, int $userId): SocialAccount;

    public function destroyAccount(int $id): void;
}
