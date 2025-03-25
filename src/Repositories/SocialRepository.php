<?php

namespace Cornatul\Social\Repositories;

use Cornatul\Social\Actions\UpdateSocialAccountConfiguration;
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
 *
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
    public final function getAccount(int $accountID): SocialAccount
    {
        return SocialAccount::with(['configuration'])->find($accountID);
    }

    /**
     * @param int $id
     * @param string $account
     * @param int $userId
     * @return SocialAccount
     */
    public final function updateAccount(int $id, string $account, int $userId): SocialAccount
    {
        $account = SocialAccount::find($id);
        $account->account = $account;
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


}
