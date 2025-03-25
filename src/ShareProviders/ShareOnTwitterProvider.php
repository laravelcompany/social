<?php

namespace Cornatul\Social\ShareProviders;

use Cornatul\Social\Contracts\ShareContract;
use GuzzleHttp\Client;

class ShareOnTwitterProvider implements ShareContract
{
    public function share(UserInformationDTO|\Cornatul\Social\DTO\UserInformationDTO $userInformationDTO, MessageDTO|\Cornatul\Social\DTO\MessageDTO $message): string
    {
        $client = new Client();

// Twitter API URL
        $url = 'https://api.twitter.com/2/tweets';

// Twitter API request headers
        $headers = [
            'Authorization' => 'Bearer ' . $userInformationDTO->token,
            'Content-Type' => 'application/json',
        ];

// Twitter API request data
        $data = [
            'text' => $message->getMessage(),
        ];

// Send a POST request to Twitter API
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $data,
        ]);

// Check the response
        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        if ($statusCode == 201) {
            echo "Tweet posted successfully!";
        } else {
            echo "Error posting tweet: $responseBody";
        }
    }
}
