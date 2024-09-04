<?php

namespace App\Http\Controllers\TravelPlans;

use App\Helpers\InterestsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TravelPlanValidator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TravelPlansController extends Controller
{
    /**
     * GET /travel-plans/create
     *
     * Display the form to create a new travel plan.
     *
     * @return View
     */
    public function create(): View
    {
        return view('travel-plans.create', [
            'interests' => InterestsHelper::interestsList()
        ]);
    }

    /**
     * POST /travel-plans/store
     *
     * Process the Travel Plan
     *
     * @param TravelPlanValidator $request
     * @return RedirectResponse
     */
    public function store(TravelPlanValidator $request): RedirectResponse
    {
        // TODO: Jogar a Job do Travel Plan.

        return redirect()->back()->with(
            'success', __('Your Travel Plan is being processed, you will receive an email when it is ready.')
        );
    }
}
