<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatSponsorshipRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Services\CatSponsorshipMailService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CatSponsorshipController extends Controller
{
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

    /**
     * @param Cat $cat
     * @param CatSponsorshipRequest $request
     */
    public function submit(Cat $cat, CatSponsorshipRequest $request)
    {
        $data = $request->all();

        $personData = PersonData::firstOrCreate(['email' => $data['personData']['email']]);
        $personData->update($data['personData']);

        Sponsorship::create([
            'person_data_id' => $personData->id,
            'cat_id' => $cat->id,
            'monthly_amount' => $data['monthly_amount'],
            'is_anonymous' => $data['is_anonymous'] ?? false,
        ]);

        CatSponsorshipMailService::sendInitialInstructionsEmail($personData);

        return back()->with('success_message', 'Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
    }
}
