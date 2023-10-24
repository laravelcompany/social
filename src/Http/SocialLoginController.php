<?php

namespace Cornatul\Social\Http;

use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SocialLoginController extends \Illuminate\Routing\Controller
{
    private SocialRepository $socialRepository;

    public function __construct(SocialRepository $socialRepository)
    {
        $this->socialRepository = $socialRepository;
    }

    /**
     * @throws \Exception
     */
    public final function login(int $account, string $provider, Request $request): string
    {
        $service = $this->socialRepository->getSocialService($account, $provider);

        $scopes = $this->socialRepository->getScopes($account, $provider);


        //set a temp session to get the account
        $this->socialRepository->setSession($account, $provider);

        if (!$request->has('code')) {
            //@todo here set scopes from the configuration dto
            $authUrl = $service->getAuthUrl([]);
            return redirect($authUrl);
        }
        abort(500, "The social code not found");

    }


    /**
     * @throws IdentityProviderException
     */
    public final function callback(Request $request): RedirectResponse
    {
        try {
            $account = session()->get('account');
            $provider = session()->get('provider');
            $provider = $this->socialRepository->getSocialService($account, $provider);
            $accessToken = $provider->getAccessToken($request->get('code'));

            //@todo inspect this to move to repository
            $user = $provider->getProfile($accessToken);
            

            //
            $credentials = SocialAccountConfiguration::where('social_account_id', $account)
                ->where('type',  session()->get('provider'))
                ->first();

            $credentials->information = json_encode([
                'access_token' => $accessToken->getToken(),
                'user' => $user,
                'refresh_token' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
            ]);

            $credentials->save();

            //remove the previous account
            $this->socialRepository->destroySession();

            return redirect()->route('social.index')
                ->with('success', 'Account connected successfully');
        } catch (\Exception $exception) {
            return redirect()->route('social.index')
                ->with('error', $exception->getMessage());
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            return redirect()->route('social.index')
                ->with('error', $e->getMessage());
        }
    }




}
