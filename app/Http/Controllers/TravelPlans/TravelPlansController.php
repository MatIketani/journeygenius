<?php

namespace App\Http\Controllers\TravelPlans;

use App\Helpers\InterestsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TravelPlanValidator;
use App\Jobs\TravelPlans\ProcessTravelPlan;
use App\Models\Auth\User;
use App\Repositories\TravelPlans\TravelPlansRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TravelPlansController extends Controller
{
    private TravelPlansRepository $travelPlansRepository;

    /**
     * Travel Plans Controller constructor.
     */
    public function __construct(TravelPlansRepository $travelPlansRepository)
    {
        $this->travelPlansRepository = $travelPlansRepository;
    }

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
        $requestData = $request->validated();

        $travelPlan = $this->travelPlansRepository->create(
            User::getInstance()->id,
            $requestData['accommodation'],
            $requestData['max_distance'],
            $requestData['interests'],
            $requestData['spending']
        );

        $job = new ProcessTravelPlan($travelPlan);

        dispatch($job);

        return redirect()->back()->with(
            'success', __('Your Travel Plan is being processed, you will receive an email when it is ready.')
        );
    }

    /**
     * GET /travel-plans/{id}
     *
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(string $id): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $travelPlanId = decrypt($id);

        $travelPlan = $this->travelPlansRepository->getById($travelPlanId);

        if (!$travelPlan) {

            abort(404);
        }

        return view('travel-plans.show', [
            'travelPlan' => $travelPlan
        ]);
    }
}
