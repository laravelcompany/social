<?php

namespace Cornatul\Social\Service;

use Cornatul\Social\Contracts\ShareContract;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Cornatul\Social\DTO\MessageDTO;
class ShareService implements ShareContract
{
    public final function share(AccessTokenInterface $accessToken, MessageDTO $message): void
    {
      dd($accessToken, $message);
    }

}
