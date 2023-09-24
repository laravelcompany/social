<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\Objects\Message;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface ShareContract
{
    public function shareOnWall(AccessTokenInterface $accessToken, Message $message): void;
}
