<?php
declare(strict_types=1);

namespace Cornatul\Social\Http;
use Cornatul\Social\Models\SocialAccount;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

/**
 * Class SocialController
 * @package Cornatul\Social\Http
 * @todo: Move the models to repository
 *
 */
class SocialController extends Controller
{
    public final function index(): View
    {
        $accounts = SocialAccount::paginate();
        return view('social::index',
        	compact('accounts')
        );
    }

    public final function view(int $id): View
    {
        $account = SocialAccount::with('configuration')->find($id);
        return view('social::view',
        	compact('account')
        );
    }


    public final function edit(int $id): View
    {
        $account = SocialAccount::with('configuration')->find($id);
        return view('social::edit',
        	compact('account')
        );
    }

    public final function update(int $id): View
    {
        //@todo implement this to update just the json field
    }
}
