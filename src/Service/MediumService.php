<?php
declare(strict_types=1);
namespace Cornatul\Social\Service;

use Cornatul\Social\Contracts\ShareContract;
use Cornatul\Social\Objects\Message;
use Illuminate\Support\Collection;
use JonathanTorres\MediumSdk\Medium;
use League\OAuth2\Client\Token\AccessTokenInterface;

class MediumService implements ShareContract
{

    public Medium $provider;

    public function __construct(Medium $provider)
    {
        $this->provider = $provider;
    }

    public function shareOnWall(AccessTokenInterface $accessToken, Message $message):void
    {

        //todo this needs to be a access token interface class
        $this->provider->connect(config('social.medium.token'));

        $user = $this->provider->getAuthenticatedUser();

        $data = [
            'title' => $message->getTitle(),
            'contentFormat' => 'markdown',
            'content' => "<img src='{$message->getImage()}' /> <br />{$message->getBody()} <br/>". Message::SIGNATURE,
            'canonicalUrl' => $message->getUrl(),
            'publishStatus' => 'public',
            'tags' => $message->getTagsAsArray(),
        ];

        $response =  collect($this->provider->createPost($user->data->id, $data));
        logger(json_encode($response));
    }
}
