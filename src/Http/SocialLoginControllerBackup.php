<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialConfigurationRepository;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GithubProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SocialLoginControllerBackup extends \Illuminate\Routing\Controller
{
    private SocialRepository $socialRepository;
    private SocialConfigurationRepository $socialConfigurationRepository;

    public function __construct(SocialRepository $socialRepository, SocialConfigurationRepository $socialConfigurationRepository)
    {
        $this->socialRepository = $socialRepository;
        $this->socialConfigurationRepository = $socialConfigurationRepository;
    }

    /**
     * @throws \Exception
     */
    public final function login(int $account, string $provider, Request $request): string
    {

        $github = Socialite::buildProvider(GithubProvider::class, [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'redirect' => 'http://example.com/callback-url',
        ])->redirect();

        dd($github);

        //first destroy session
        $this->socialRepository->destroySession();

        //now create a session
        $this->socialRepository->setSession($account, $provider);

        //now get the service
        $service = $this->socialRepository->getSocialService();

        //get the scopes
        $scopes =   $data = SocialAccountConfiguration::where('social_account_id',$account)
            ->where('type',$provider)->first();


        if (!$request->has('code'))
        {
            $authUrl = $service->getAuthUrl( $scopes->configuration->scopes );

            return redirect($authUrl);
        }
        abort(500, "The social code not found");

    }


    /**
     * @throws IdentityProviderException
     * @throws RuntimeException
     */
    public final function callback(Request $request): RedirectResponse
    {
        $socialService = $this->socialRepository->getSocialService();

        $code =  $request->get('code');
        $state =  $request->get('state');

        $code_verifier = request()->session()->get('oauth2verifier') ?? '';



        $accessToken = $socialService->getAccessToken($code, $state);

        $user = $socialService->getProfile($accessToken);

        $save = [
            'access_token' => $accessToken->getToken(),
            'user' => $user->toArray(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
        ];

        $this->socialConfigurationRepository->saveAccountConfiguration($save);
        $this->socialRepository->destroySession();

        try {
            return redirect()->route('social.index')->with('success', 'Account connected successfully');
        } catch (\Exception $exception) {
            return redirect()->route('social.index')->with('error', $exception->getMessage());
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            return redirect()->route('social.index')->with('error', $e->getMessage());
        }
    }




}
