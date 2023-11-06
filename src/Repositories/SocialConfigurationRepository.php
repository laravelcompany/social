<?php

namespace Cornatul\Social\Repositories;

use Cornatul\Social\Actions\CreateSocialAccountConfiguration;
use Cornatul\Social\Actions\UpdateSocialAccountConfiguration;
use Cornatul\Social\Contracts\SocialConfiguration;
use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\DTO\ConfigurationDTO;
use Cornatul\Social\DTO\UserInformationDTO;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Service\SocialOauthService;
use Illuminate\Database\QueryException;
use League\OAuth2\Client\Provider\LinkedIn;
use Smolblog\OAuth2\Client\Provider\Twitter;
use RuntimeException;

/**
 *
 */
class SocialConfigurationRepository implements SocialConfiguration
{
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


    public final function saveAccountInformation(UserInformationDTO $userInformationDTO):bool
    {

        $account = request()->session()->get('account');

        $provider = request()->session()->get('provider');

        $credentials = SocialAccountConfiguration::where('social_account_id', $account)
            ->where('type', $provider)
            ->first();

        $credentials->information = ($userInformationDTO->toJson());

        return $credentials->save();

    }

    //destroy configuration
    public final function destroyAccountConfiguration(int $account, string $type): bool
    {
        $configuration = SocialAccountConfiguration::where('social_account_id', $account)->where('type', $type)->first();

        if (!$configuration) {
            throw new \RuntimeException("Account with id {$account} not found in the database");
        }

        return $configuration->delete();
    }



    /**
     * @throws \Exception
     */
    public final function updateAccountConfiguration(UpdateSocialAccountConfiguration $request,): SocialAccountConfiguration
    {
        $data = SocialAccountConfiguration::where('social_account_id',$request->input('id'))
            ->where('type',$request->input('type'))->first();

        if (!$data) {
            throw new \Exception("Account with id {$request->input('account')} not found in the database");
        }

        $configuration = json_encode([
            'client_id' =>  $request->input('client_id'),
            'client_secret' =>  $request->input('client_secret'),
            'redirect' => $request->input('redirect'),
            'scopes' =>  explode(',', $request->input('scopes'))
        ]);

        $data->configuration = $configuration;
        $data->save();
        return $data;
    }


    public final function createAccountConfiguration(CreateSocialAccountConfiguration $request): SocialAccountConfiguration
    {
        return SocialAccountConfiguration::create([
            'social_account_id' => $request->input('account'),
            'type' => $request->input('type'),
            'configuration' =>json_encode([
                'client_id' => $request->input('client_id'),
                'client_secret' => $request->input('client_secret'),
                'redirect' => $request->input('redirect'),
                'scopes' => explode(',', $request->input('scopes'))
            ]),
        ]);
    }

}
