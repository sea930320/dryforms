<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plans\PlanStore;
use Prologue\Alerts\Facades\Alert;
use Stripe\Plan;
use Stripe\Stripe;

class PlansController extends Controller
{
    /**
     * @var Stripe
     */
    private $stripe;

    /**
     * @var Plan
     */
    private $plan;

    /**
     * PlansController constructor.
     *
     * @param Stripe $stripe
     * @param Plan $plan
     */
    public function __construct(Stripe $stripe, Plan $plan)
    {
        $this->stripe = $stripe;
        $this->plan = $plan;

        $this->stripe->setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $plans = $this->plan->all();

        return view('dashboard.payments.plans.index', compact('plans'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.payments.plans.form');
    }

    /**
     * @param PlanStore $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PlanStore $request)
    {
        $this->plan->create([
            'amount' => $request->get('amount') * 100,
            'interval' => $request->get('interval'),
            'name' => $request->get('name'),
            'trial_period_days' => $request->get('trial_period_days'),
            'currency' => 'usd',
            'id' => kebab_case(strtolower($request->get('name'))),
        ]);

        Alert::success('Plan successfully created')->flash();

        return redirect()->route('plans.index')->with('alerts', Alert::all());
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $plan = $this->plan->retrieve($id);
        $plan->delete();

        Alert::success('Plan successfully deleted')->flash();

        return redirect()->route('plans.index')->with('alerts', Alert::all());
    }
}