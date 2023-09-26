<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\Repositories\SocialRepository;

class SocialLoginController extends \Illuminate\Routing\Controller
{
    private SocialRepository $socialRepository;

    public function __construct()
    {
        $this->socialRepository = new SocialRepository();
    }

    /**
     * @throws \Exception
     */
    public final function login(int $user_id, string $provider): void
    {
          $service = $this->socialRepository->getSocialService($user_id, $provider);

            //set session
        dd($service, $provider);

    }

}
