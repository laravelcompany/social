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

    public function __construct()
    {
        $this->socialRepository = new SocialRepository();
    }

    /**
     * @throws \Exception
     */
    public final function login(int $user_id, string $provider, Request $request): string
    {
        $service = $this->socialRepository->getSocialService($user_id, $provider);

        //set a temp session to get the account
        $this->socialRepository->setSession($user_id, $provider);

        if (!$request->has('code')) {
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

            $user = $provider->getProfile($accessToken);

            $credentials = SocialAccountConfiguration::find($account);


            $credentials->information = json_encode([
                'access_token' => $accessToken->getToken(),
                'user' => $user
            ]);

            $credentials->save();

            //remove the previous account
            $this->socialRepository->destroyAccount($account);

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
