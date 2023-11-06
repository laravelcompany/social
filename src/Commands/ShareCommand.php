<?php

declare(strict_types=1);
namespace Cornatul\Social\Commands;

use Cornatul\Crawler\Interfaces\CrawlerInterface;
use Cornatul\Social\DTO\MessageDTO;
use Cornatul\Social\DTO\UserInformationDTO;
use Cornatul\Social\Managers\ShareManager;
use Cornatul\Social\Models\SocialAccountConfiguration;
use GuzzleHttp\ClientInterface;
use Illuminate\Console\Command;
use Cornatul\Crawler\DTO\CrawlerDTO;
use Cornatul\Crawler\Interfaces\SentimentInterface;

class ShareCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected static $defaultName = 'social:share';

    /**
     * @var string The name and signature of this command.
     */
    protected $signature = 'social:share';

    /**
     * @var string The console command description.
     */
    protected $description = 'Thi swill share a message on connected social networks.';

    /**
     * Execute the console command.
     * @param ClientInterface $client
     * @return void
     */
    final public function handle(ClientInterface $client, CrawlerInterface $htmlClientContract): void
    {
        $this->output->success('Welcome to share command!');

        $socialAccounts = SocialAccountConfiguration::where('social_account_id', 1)
            ->whereNotNull('information')
            ->get();


        foreach ($socialAccounts as $socialAccount) {

            $userInformation = UserInformationDTO::from($socialAccount->information);
            $manager = new ShareManager();
            $manager->share($userInformation, new MessageDTO('Hello world!'));
        }

    }
}
