<?php

namespace Cornatul\Social\Repositories;

use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Service\SocialOauthService;
use Illuminate\Database\QueryException;
use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\LinkedIn;
use Smolblog\OAuth2\Client\Provider\Twitter;
use RuntimeException;

/**
 * @todo Refactor this class to implement multiple interfaces
 */
class SocialRepository implements SocialContract
{
    private const ACCOUNT_TWITTER = 'twitter';
    private const ACCOUNT_LINKEDIN = 'linkedin';
    private const ACCOUNT_FACEBOOK = 'facebook';

    private const ACCOUNT_GOOGLE = 'google';

    private array $providerClasses = [
        self::ACCOUNT_TWITTER => Twitter::class,
        self::ACCOUNT_LINKEDIN => LinkedIn::class,
        self::ACCOUNT_FACEBOOK => Facebook::class,
        self::ACCOUNT_GOOGLE => Google::class,
    ];

    public final function createAccount(string $name, int $userId): SocialAccount
    {
        return SocialAccount::create([
            'account' => $name,
            'user_id' => $userId,
        ]);
    }
    public final function getAccount(int $id): SocialAccount
    {
        return SocialAccount::with(['configuration'])->find($id)->first();
    }

    /**
     * @todo refactor this to use the configuration dto
     * @param int $id
     * @param string $name
     * @param int $userId
     * @return SocialAccount
     */
    public final function updateAccount(int $id, string $name, int $userId): SocialAccount
    {
        $account = SocialAccount::find($id);
        $account->account = $name;
        $account->user_id = $userId;
        $account->save();
        return $account;
    }
    public final function destroyAccount(int $id): void
    {
        $account = SocialAccount::find($id);
        $account->delete();
    }
    /**
     * @throws \Exception
     */
    public final function getSocialService(int $user_id, string $provider): SocialOauthService
    {
        $data = SocialAccountConfiguration::where('social_account_id',$user_id)
            ->where('type',$provider)->first();

        $credentials = ConfigurationDTO::from($data);

        $providerClass = $this->providerClasses[$data->type] ?? null;

        if (is_null($providerClass)) {
            throw new RuntimeException("This type of service is not supported or it is not implemented yet");
        }

        $provider = new $providerClass((array) $credentials->configuration);

        return new SocialOauthService($provider);
    }

    /**
     * @throws \Exception
     */
    public final function updateAccountConfiguration(
        int $account,
        string $type,
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        array $scopes
    ): SocialAccountConfiguration
    {
        $data = SocialAccountConfiguration::where('social_account_id',$account)
            ->where('type',$type)->first();

        if (!$data) {
            throw new \Exception("Account with id {$account} not found in the database");
        }

        $configurationDTO = json_encode([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
            'scopes' => $scopes
        ]);

        $data->configuration = $configurationDTO;
        $data->save();
        return $data;
    }

    /**
     * @throws \RuntimeException
     */
    public final function getAccountConfiguration(int $account,string $type): ConfigurationDTO
    {
        $data = SocialAccountConfiguration::where('social_account_id', $account)->where('type', $type)->first();

        if (!$data) {
            throw new \RuntimeException("Account with id {$account} not found in the database");
        }

        return ConfigurationDTO::from($data);
    }


    public final function setSession(int $account, string $provider): self
    {
        session()->put('account', $account);
        session()->put('provider', $provider);
        return $this;
    }

    public final function destroySession(): self
    {
        session()->remove('account');
        session()->remove('provider');
        return $this;
    }


    /**
     * @throws \Exception
     */
    public final function createAccountConfiguration(
        int $account,
        string $type,
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        array $scopes
    ): SocialAccountConfiguration
    {

        try {

            return SocialAccountConfiguration::create([
                'social_account_id' => $account,
                'type' => $type,
                'configuration' =>json_encode([
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                    'redirectUri' => $redirectUri,
                    'scopes' => $scopes
                ]),
            ]);
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
