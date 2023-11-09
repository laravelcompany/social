<?php

namespace Cornatul\Social\Managers;

class SocialSessionManager
{
    public final function setSocialCurrentSessions(int $account, string $provider): self
    {
        session()->put('account', $account);
        session()->put('provider', $provider);
        return $this;
    }

    public final function destroySocialSessions(): self
    {
        session()->remove('account');
        session()->remove('provider');
        session()->remove('oauth2state');
        session()->remove('oauth2verifier');
        return $this;
    }

    public final function getCurrentSocialAccountSessions(string $sessionName): array
    {

        $sessions =  [
            'account' => session()->get('account'),
            'provider' => session()->get('provider'),
        ];

        return $sessions[$sessionName];
    }

}
