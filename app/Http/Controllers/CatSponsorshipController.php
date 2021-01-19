<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatSponsorshipRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SponsorshipMail;

/**
 * Class CatSponsorshipController
 * @package App\Http\Controllers
 */
class CatSponsorshipController extends Controller
{

    /**
     * Handle incoming cat sponsorship form request.
     *
     * @param Cat $cat
     * @param CatSponsorshipRequest $request
     * @return RedirectResponse
     */
    public function submit(Cat $cat, CatSponsorshipRequest $request): RedirectResponse
    {
        $input = $request->all();

        if (Auth::check()) {
            $this->updateUserEmail(Auth::user(), $input['personData']['email']);
        }

        $personData = $this->updateOrCreatePersonData($request->input('personData'));
        $this->createSponsorship($cat, $personData, $input);
        SponsorshipMail::sendInitialInstructionsEmail($personData);

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
     * @param array $personDataFormInput
     * @return PersonData|Model
     */
    protected function updateOrCreatePersonData(array $personDataFormInput)
    {
        $personData = PersonData::firstOrCreate(['email' => $personDataFormInput['email']]);
        $personData->update($personDataFormInput);
        $personData->refresh();

        return $personData;
    }

    /**
     * @param Cat $cat
     * @param PersonData $personData
     * @param array $formInput
     */
    protected function createSponsorship(Cat $cat, PersonData $personData, array $formInput)
    {
        Sponsorship::create([
            'person_data_id' => $personData->id,
            'cat_id' => $cat->id,
            'monthly_amount' => $formInput['monthly_amount'],
            'is_anonymous' => $formInput['is_anonymous'] ?? false,
            'is_active' => false,
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
