<?php
declare(strict_types=1);

namespace Cornatul\Social\Http;
use Cornatul\Social\Actions\CreateNewSocialAccount;
use Cornatul\Social\Contracts\ShareContract;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Models\SocialAccountConfiguration;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

/**
 * Class SocialController
 * @package Cornatul\Social\Http
 */
class ShareController extends Controller
{
    public final function share(int $account): Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('social::share',
        	compact('account')
        );
    }


    public final function process(ShareContract $contract, Request $request): RedirectResponse
    {
        //todo implementation
        return redirect()->route('social.index');
    }
}
