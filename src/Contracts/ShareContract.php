<?php

namespace Cornatul\Social\Contracts;

use Cornatul\Social\DTO\MessageDTO;
use Cornatul\Social\DTO\UserInformationDTO;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface ShareContract
{
    public function share(UserInformationDTO $userInformationDTO, MessageDTO $message): string;
}
