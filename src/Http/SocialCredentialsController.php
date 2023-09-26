<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\Actions\UpdateSocialAccountConfiguration;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SocialCredentialsController extends \Illuminate\Routing\Controller
{
    private SocialRepository $socialRepository;

    public function __construct()
    {
        $this->socialRepository = new SocialRepository();
    }


    public final function create(int $account): View|Application
    {
        return view('social::credentials.create', [
            'account' => $account
        ]);
    }


    /**
     * @throws \Exception
     */
    public final function edit(int $credentialsID): View|Application
    {
        $credentials = $this->socialRepository->getAccountConfiguration($credentialsID);
        $socialAccountConfiguration = SocialAccountConfiguration::find($credentialsID);

        return view('social::credentials.edit', [
            'credentials' => $credentials,
            'socialAccountConfiguration' => $socialAccountConfiguration
        ]);
    }


    public final function update(UpdateSocialAccountConfiguration $request): RedirectResponse
    {


        dd($request->all());
    }

}
