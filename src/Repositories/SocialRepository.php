<?php

namespace Cornatul\Social\Repositories;

use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Service\SocialOauthService;
use Illuminate\Database\QueryException;
use League\OAuth2\Client\Provider\LinkedIn;
use League\OAuth2\Client\Provider\Twitter;
use RuntimeException;

class SocialRepository
{

    private const ACCOUNT_TWITTER = 'twitter';
    private const ACCOUNT_LINKEDIN = 'linkedin';
    private const ACCOUNT_FACEBOOK = 'facebook';

    private array $providerClasses = [
        self::ACCOUNT_TWITTER => Twitter::class,
        self::ACCOUNT_LINKEDIN => LinkedIn::class,
        self::ACCOUNT_FACEBOOK => LinkedIn::class,
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
        return SocialAccount::with('configuration')->find($id)->first();
    }
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


        $credentials = ConfigurationDTO::from($data->configuration);

        $providerClass = $this->providerClasses[$data->type] ?? null;

        if (!$providerClass) {
            throw new RuntimeException("This type of service is not supported");
        }

        $provider = new $providerClass($credentials->toArray());

        return new SocialOauthService($provider);
    }

    /**
     * @throws \Exception
     */
    public final function getAccountFromSession(): int
    {
        $account = session()->get('account');

        if (!$account) {
            throw new \Exception("Account not found in session");
        }

        return $account;
    }

    /**
     * @throws \Exception
     */
    public final function saveAccountInformation(ConfigurationDTO $configurationDTO, int $account): void
    {
        $data = SocialAccountConfiguration::find($account);

        if (!$data) {
            throw new \Exception("Account with id {$account} not found in the database");
        }

        $data->information = $configurationDTO->toJson();
        $data->save();
    }
}
