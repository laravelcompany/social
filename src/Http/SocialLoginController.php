<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\DTO\UserInformationDTO;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialConfigurationRepository;
use Cornatul\Social\Repositories\SocialRepository;
use Cornatul\Social\Social\CustomLinkedInProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Two\GithubProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\LinkedInProvider;
use Laravel\Socialite\Two\TwitterProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SocialLoginController extends \Illuminate\Routing\Controller
{
    private SocialRepository $socialRepository;
    private SocialConfigurationRepository $socialConfigurationRepository;

    protected array $providers = [
        'github' => GithubProvider::class,
        'twitter' => TwitterProvider::class,
        'linkedin' => CustomLinkedInProvider::class,
        'facebook' => FacebookProvider::class,
        'google' => GoogleProvider::class,
    ];

    public function __construct(SocialRepository $socialRepository, SocialConfigurationRepository $socialConfigurationRepository)
    {
        $this->socialRepository = $socialRepository;
        $this->socialConfigurationRepository = $socialConfigurationRepository;

    }

    /**
     * @todo move the logic of the session to the repo
     * @throws \Exception
     */
    public final function login(int $account, string $provider, Request $request): string
    {
        //remove if we have older session ( this allows us to have multiple accounts)
        session()->remove('account');
        session()->remove('provider');

        //set a new session
        session()->put('account', $account);
        session()->put('provider', $provider);

        $configuration = $this->socialConfigurationRepository->getAccountConfiguration($account, $provider);

        $providerClass = $this->providers[$provider] ?? "The selected '$provider' is not yet implemented";

        return Socialite::buildProvider($providerClass, (array) $configuration->configuration)
            ->scopes($providerClass->scopes ?? [])
            ->redirect();

    }


    /**
     *
     * @throws IdentityProviderException
     * @throws RuntimeException
     */
    public final function callback(Request $request): RedirectResponse
    {
        //get the sessions
        $account = session()->get('account');
        $provider = session()->get('provider');



        $providerClass = $this->providers[$provider] ?? "The selected '$provider' is not yet implemented";
        $configuration = $this->socialConfigurationRepository->getAccountConfiguration($account, $provider);
        $user = Socialite::buildProvider($providerClass, (array) $configuration->configuration)
            ->scopes($providerClass->scopes ?? [])
            ->user();
        $data = UserInformationDTO::from([
            // OAuth 2.0 providers
            'token' => $user->token,
            'refreshToken' => $user->refreshToken,
            'expiresIn' => $user->expiresIn,

            // All providers
            'id' => $user->getId(),
            'nickname' => $user->getNickname(),
            'name' => $user->getName(),
            'email' => "",
            'avatar' => $user->getAvatar(),
        ]);

        $this->socialConfigurationRepository->saveAccountInformation($data);
        //todo destroy the sessions
        session()->remove('account');
        session()->remove('provider');

        return redirect()->route('social.index')->with('success', "Account {$provider} connected successfully");

    }

}
