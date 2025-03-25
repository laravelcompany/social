<?php

namespace Cornatul\Social\Tests\Unit;

use Cornatul\Social\Contracts\ShareContract;
use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\DTO\TwitterTrendingDTO;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Objects\Message;
use Cornatul\Social\Service\TumblrService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Mockery;


/**
 * Class SocialTest
 * @todo Implement tests for social interface
 * @covers \Cornatul\Social\Service\TumblrService
 */
class SocialTest extends \Cornatul\Social\Tests\TestCase
{

    /** @test */
    public function it_updates_social_account():void
    {
        $interfaceMock = $this->getMockForAbstractClass(SocialContract::class);

        // Define test data
        $name = "TestAccount";
        $userId = 1;

        // Define the expected result
        $expectedResult = new SocialAccount([
            'account' => $name,
            'user_id' => $userId,
        ]);

        // Stub the create method on the mock
        $interfaceMock->method('createAccount')->willReturn($expectedResult);

        // Call the createAccount method
        $result = $interfaceMock->createAccount($name, $userId);

        // Assert that the result matches the expected result
        $this->assertEquals($expectedResult, $result);
    }
}
