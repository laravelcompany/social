<?php
declare(strict_types=1);

namespace Cornatul\Social\Http;


use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Objects\Message;
use Cornatul\Social\Repositories\SocialRepository;
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


class LinkedInController extends Controller
{

    private SocialRepository $socialRepository;

    public function __construct()
    {
        $this->socialRepository = new SocialRepository();
    }

    /**
     * @throws \Exception
     */
    public final function login(int $account, Request $request): RedirectResponse
    {
        $service = $this->socialRepository->getSocialService($account);

        //set session
        session()->put('account', $account);

        if (!$request->has('code')) {
            $authUrl = $service->getAuthUrl();
            return redirect($authUrl);
        }

        abort(500, "The social code not found");
    }


    //generate callback function

    /**
     * @throws IdentityProviderException
     * @todo refactor this
     */
    public function callback(Request $request)
    {
        try {
            $account = $this->socialRepository->getAccountFromSession();
            $provider = $this->socialRepository->getSocialService($account);
            $accessToken = $provider->getAccessToken($request->get('code'));

            $user = $provider->getProfile($accessToken);

            $credentials = SocialAccountConfiguration::find($account);


            $credentials->information = json_encode([
                'access_token' => $accessToken->getToken(),
                'user' => $user
            ]);

            $credentials->save();

            //remove the previous account
            session()->remove('account');

            return redirect()->route('social.index')
                ->with('success', 'LinkedIn account connected successfully');
        } catch (\Exception $exception) {
            return redirect()->route('social.index')
                ->with('error', $exception->getMessage());
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            return redirect()->route('social.index')
                ->with('error', $e->getMessage());
        }
    }
}
