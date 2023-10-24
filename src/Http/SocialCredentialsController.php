<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\Actions\CreateSocialAccountConfiguration;
use Cornatul\Social\Actions\UpdateSocialAccountConfiguration;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class SocialCredentialsController extends Controller
{
    private SocialRepository $socialRepository;

    public function __construct(SocialRepository $socialRepository)
    {
        $this->socialRepository = $socialRepository;
    }

    public final function create(int $account): View|Application
    {
        return view('social::credentials.create', [
            'account' => $account,
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


    /**
     * @method update
     * @param UpdateSocialAccountConfiguration $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public final function update(UpdateSocialAccountConfiguration $request): RedirectResponse
    {

        $this->socialRepository->updateAccountConfiguration(
            $request->input('id'),
            $request->input('type'),
            $request->input('clientId'),
            $request->input('clientSecret'),
            $request->input('redirectUri'),
            explode(',', $request->input('scopes'))
        );

        return redirect()->route('social.index')->with('success', 'Credentials updated successfully');
    }


    /**
     * @method save
     * @param UpdateSocialAccountConfiguration $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public final function save(CreateSocialAccountConfiguration $request): RedirectResponse
    {

        $this->socialRepository->createAccountConfiguration(
            $request->input('account'),
            $request->input('type'),
            $request->input('clientId'),
            $request->input('clientSecret'),
            $request->input('redirectUri'),
            explode(',', $request->input('scopes'))
        );

        return redirect()->route('social.index')->with('success', 'Credentials created successfully');
    }

}
