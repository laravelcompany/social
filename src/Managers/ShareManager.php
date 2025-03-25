<?php

namespace Cornatul\Social\Managers;

use Cornatul\Social\DTO\MessageDTO;
use Cornatul\Social\DTO\UserInformationDTO;
use Cornatul\Social\ShareProviders\ShareOnLinkedInProvider;
use Cornatul\Social\ShareProviders\ShareOnTwitterProvider;

class ShareManager implements \Cornatul\Social\Contracts\ShareContract
{
    //todo Add the client interface to the constructor
    //todo Move the UserInformationDTO to a higher lvl
    private array $socialShareServices = [
        ShareOnLinkedInProvider::class,
        ShareOnTwitterProvider::class
    ];

    public final function share(UserInformationDTO $userInformationDTO, MessageDTO $message): string
    {
        $responses = collect();
        foreach ($this->socialShareServices as $socialShareService) {
            $socialShareService = new $socialShareService();
            try {
                $response = $socialShareService->share($userInformationDTO, $message);
            } catch (\RuntimeException $exception) {
                $responses->push([
                    'service' => $socialShareService::class,
                    'response' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace(),
                    'status' => 'error',
                ]);
            }
        }

        dd($responses);
    }
}
