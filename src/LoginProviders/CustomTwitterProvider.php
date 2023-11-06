<?php

namespace Cornatul\Social\LoginProviders;

use Laravel\Socialite\Two\TwitterProvider;

class CustomTwitterProvider extends TwitterProvider
{
    protected $scopes = ['users.read', 'tweet.read', "tweet.write"];
}
