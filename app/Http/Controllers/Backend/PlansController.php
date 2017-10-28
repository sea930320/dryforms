<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Stripe\Plan;

class PlansController extends Controller
{
    private $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function index()
    {
        return view('dashboard.payments.plans.index');
    }
}