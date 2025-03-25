<?php
declare(strict_types=1);

namespace Cornatul\Social\Http;
use Cornatul\Social\Actions\CreateNewSocialAccount;
use Cornatul\Social\Contracts\SocialContract;
use Cornatul\Social\Models\SocialAccount;
use Cornatul\Social\Repositories\SocialRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    protected  SocialRepository $socialRepository;

    public final function __construct(SocialRepository $socialRepository)
    {
        $this->middleware('auth');
        $this->socialRepository = $socialRepository;
    }

    public final function index(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $accounts = SocialAccount::paginate();
        return view('social::index',
        	compact('accounts')
        );
    }

    public final function view(int $accountID): View
    {
        $account = $this->socialRepository->getAccount($accountID);
        return view('social::view',
        	compact('account')
        );
    }

    public final function create(): View
    {
        return view('social::create');
    }

    public final function save(CreateNewSocialAccount $request, SocialRepository $repository): RedirectResponse
    {
        $repository->createAccount(
            $request->get('name'),
            (int) $request->get('user_id')
        );

        return redirect()->route('social.index')->with('success','Account has been saved');
    }


    public final function edit(int $id): View
    {
        $account = SocialAccount::with('configuration')->find($id);
        return view('social::edit',
        	compact('account')
        );
    }


    public final function update(int $id, SocialRepository $repository, CreateNewSocialAccount $request): RedirectResponse
    {
        $repository->updateAccount(
            $id,
            $request->get('name'),
            (int) $request->get('user_id')
        );

        return redirect()->route('social.index')->with('success', 'Social Account updated!');
    }


    public final function destroy(int $id, SocialRepository $repository): RedirectResponse
    {
        $repository->destroyAccount($id);
        return redirect()->route('social.index')->withMessage('Account has been deleted');
    }
}
