<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatSponsorshipRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Models\User;
use App\Services\CatSponsorshipMailService;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class CatSponsorshipController
 * @package App\Http\Controllers
 */
class CatSponsorshipController extends Controller
{

    /**
     * @var CatSponsorshipMailService
     */
    protected CatSponsorshipMailService $catSponsorshipMailService;

    /**
     * @param CatSponsorshipMailService $catSponsorshipMailService
     */
    public function __construct(CatSponsorshipMailService $catSponsorshipMailService)
    {
        $this->catSponsorshipMailService = $catSponsorshipMailService;
    }

    /**
     * Handle incoming cat sponsorship form request.
     *
     * @param Cat $cat
     * @param CatSponsorshipRequest $request
     * @return RedirectResponse
     */
    public function submit(Cat $cat, CatSponsorshipRequest $request)
    {
        $input = $request->all();
        if (Auth::check()) {
            $this->updateUserEmail(Auth::user(), $input['personData']['email']);
        }
        $personData = $this->updateOrCreatePersonData($request->input('personData'));
        $this->createSponsorship($cat, $personData, $input);
        $this->catSponsorshipMailService->sendInitialInstructionsEmail($personData);
        return back()->with(
            'success_message',
            'Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.'
        );
    }

    /**
     * @param User|Authenticatable $user
     * @param string $inputEmail
     */
    protected function updateUserEmail($user, string $inputEmail)
    {
        if ($inputEmail === $user->email) {
            return;
        }
        $user->update(['email' => $inputEmail]);
    }

    /**
     * @param array $updates
     * @return PersonData|Model
     */
    protected function updateOrCreatePersonData(array $updates)
    {
        $personData = PersonData::firstOrCreate(['email' => $updates['email']]);
        $personData->update($updates);
        return $personData;
    }

    /**
     * @param Cat $cat
     * @param PersonData $personData
     * @param array $input
     */
    protected function createSponsorship(Cat $cat, PersonData $personData, array $input)
    {
        Sponsorship::create([
            'person_data_id' => $personData->id,
            'cat_id' => $cat->id,
            'monthly_amount' => $input['monthly_amount'],
            'is_anonymous' => $input['is_anonymous'] ?? false,
        ]);
    }

    /**
     * Show the page with the form for sponsoring a cat.
     *
     * @param Cat $cat
     * @return Application|Factory|View|void
     */
    public function form(Cat $cat)
    {
        return view('become_cat_sponsor', ['cat' => $cat]);
    }
}
