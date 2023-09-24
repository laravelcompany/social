<?php
declare(strict_types=1);
namespace Cornatul\Social\Http;



use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Objects\Message;
use Cornatul\Social\Service\LinkedInService;
use Cornatul\Social\Service\SocialOauthService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\LinkedIn;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class FacebookController extends Controller
{

    public final function login(int $account, Request $request): RedirectResponse
    {

        //set session
        session()->put('twitter_account', $account);

        $credentials = SocialAccountConfiguration::find($account);

        $config = json_decode($credentials->configuration, false);

        if (!$credentials) {
            abort(500, "Account not found");

        }

        $provider = new ([
            'clientId' => $config->client_id,
            'clientSecret' => $config->client_secret,
            'redirectUri' => $config->redirect_uri,
        ]);

        $service = new SocialOauthService($provider);

        if (!$request->has('code')) {
            $authUrl = $service->getAuthUrl();
            return redirect($authUrl);
        }
    }


    //generate callback function

    /**
     * @throws IdentityProviderException
     */
    public function callback(Request $request)
    {
        $account = session()->get('linkedin_account');

        if (!$account) {
            abort(500, "Account not found");
        }

        $credentials = SocialAccountConfiguration::with('account')->find($account);

        $config = json_decode($credentials->configuration, false);

        $provider = new LinkedIn([
            'clientId' => $config->client_id,
            'clientSecret' => $config->client_secret,
            'redirectUri' => $config->redirect_uri,
        ]);

        $service = new SocialOauthService($provider);

        $accessToken = $service->getAccessToken($request->input('code'));

        $user = $provider->getResourceOwner($accessToken);

        //@todo rename this to data
        $credentials->token = json_encode([
            "user" => [
                "id" => $user->getId(),
                "name" => $user->getFirstName() . ' ' . $user->getLastName(),
                "email" => $user->getEmail(),
            ],
            'token' => $accessToken,
        ]);

        $credentials->save();

        //remove the previous account
        session()->remove('linkedin_account');

        return redirect()->route('social.index')
            ->with('success', 'LinkedIn account connected successfully');
    }
}
