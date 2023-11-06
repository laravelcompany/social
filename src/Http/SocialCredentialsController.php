<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\Actions\CreateSocialAccountConfiguration;
use Cornatul\Social\Actions\UpdateSocialAccountConfiguration;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialConfigurationRepository;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class SocialCredentialsController extends Controller
{

    private SocialConfigurationRepository $socialConfigurationRepository;

    public function __construct(
        SocialConfigurationRepository $socialConfigurationRepository
    )
    {
        $this->socialConfigurationRepository = $socialConfigurationRepository;
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
    public final function edit(int $account, string $provider): View|Application
    {
        $credentials = $this->socialConfigurationRepository->getAccountConfiguration($account, $provider);

        return view('social::credentials.edit', [
            'credentials' => $credentials,
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
        $this->socialConfigurationRepository->updateAccountConfiguration($request);

        return redirect()->route('social.index')->with('success', 'Credentials updated successfully');
    }


    /**
     * @method save
     * @param CreateSocialAccountConfiguration $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public final function save(CreateSocialAccountConfiguration $request): RedirectResponse
    {

        $this->socialConfigurationRepository->createAccountConfiguration($request);

        return redirect()->route('social.index')->with('success', 'Credentials created successfully');
    }

    /**
     * @param int $account
     * @param string $provider
     * @return RedirectResponse
     */
    public final function destroy(int $account, string $provider): RedirectResponse
    {
        $this->socialConfigurationRepository->destroyAccountConfiguration($account, $provider);

        return redirect()->route('social.index')->with('success', 'Credentials deleted successfully');
    }
}
