<?php

namespace Cornatul\Social\Social;

use Laravel\Socialite\Two\TwitterProvider;

class CustomTwitterProvider extends TwitterProvider
{
    protected $scopes = ['users.read', 'tweet.read', "twitter.write"];
}
