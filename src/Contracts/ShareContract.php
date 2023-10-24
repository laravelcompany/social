<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\DTO\MessageDTO;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface ShareContract
{
    public function share(AccessTokenInterface $accessToken, MessageDTO $message): void;
}
