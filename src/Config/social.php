<?php

return [
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID', ''),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET', ''),
        'redirect_uri' => env('LINKEDIN_REDIRECT_URI', ''),
        'scopes' => [
            'r_liteprofile',
            'w_member_social',
            'openid',
            'r_emailaddress',
            'profile',
            'email',
        ]
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', ''),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
        'redirect_uri' => env('FACEBOOK_REDIRECT_URI', ''),
        'scopes' =>[
            'pages_manage_posts',
            'pages_read_engagement',
            'user_posts'

        ]
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID', ''),
        'client_secret' => env('TWITTER_CLIENT_SECRET', ''),
        'redirect_uri' => env('TWITTER_REDIRECT_URI', ''),
        'consumer_key' => env('TWITTER_CONSUMER_KEY', ''),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET', ''),
        'access_token' => env('TWITTER_ACCESS_TOKEN', ''),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET', ''),

        'scopes' => [
            'tweet.read',
            'users.read',
            'offline.access',
            'tweet.write'
        ],
    ],
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', ''),
        'client_secret' => env('GITHUB_CLIENT_SECRET', ''),
        'redirect_uri' => env('GITHUB_REDIRECT_URI', ''),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', ''),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI', ''),
    ],

    'medium' => [
        'token' => env('MEDIUM_TOKEN', ''),
    ],
    'devto' => [
        'token' => env('DEVTO_TOKEN', ''),
    ],
    'tumblr' => [
        'identifier' => env('TUMBLR_IDENTIFIER', ''),
        'secret' => env('TUMBLR_SECRET', ''),
        'callback_uri' => env('TUMBLR_REDIRECT_URI', ''),
        'blog' => env('TUMBLR_BLOG_NAME', ''),
    ],
];
