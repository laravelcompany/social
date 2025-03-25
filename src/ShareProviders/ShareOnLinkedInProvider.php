<?php

namespace Cornatul\Social\ShareProviders;

use Cornatul\Social\Contracts\ShareContract;

class ShareOnLinkedInProvider implements ShareContract
{
    public function share(UserInformationDTO|\Cornatul\Social\DTO\UserInformationDTO $userInformationDTO, MessageDTO|\Cornatul\Social\DTO\MessageDTO $message): string
    {
        $client = new \GuzzleHttp\Client();

        $linkedinAccessToken = $userInformationDTO->token;

        $shareContent = 'Content you want to post on LinkedIn';


        $response = $client->post('https://api.linkedin.com/v2/shares', [
            'headers' => [
                'Authorization' => 'Bearer ' . $linkedinAccessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'comment' => $shareContent,
                'visibility' => ['code' => 'anyone'],
                'content' => [
                    'title' => 'LinkedIn Developers Resources',
                    'description' => 'Leverage LinkedIn\'s APIs to maximize engagement',
                    'submitted-url' => 'https://developer.linkedin.com',
                    'submitted-image-url' => 'https://example.com/logo.png'
                ],
                'owner' => 'urn:li:person:' . $userInformationDTO->id,
            ],
        ]);

        if ($response->getStatusCode() == 201) {
            return "Post on LinkedIn successful!";
        } else {
            return "Error posting on LinkedIn: " . $response->getBody()->getContents();
        }
    }
}
