<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupons\CouponStore;
use Prologue\Alerts\Facades\Alert;
use Stripe\Coupon;
use Stripe\Stripe;

class CouponsController extends Controller
{
    /**
     * @var Stripe
     */
    private $stripe;

    /**
     * @var Coupon
     */
    private $coupon;

    /**
     * CouponsController constructor.
     *
     * @param Stripe $stripe
     * @param Coupon $coupon
     */
    public function __construct(Stripe $stripe, Coupon $coupon)
    {
        $this->stripe = $stripe;
        $this->coupon = $coupon;

        $this->stripe->setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $coupons = $this->coupon->all();

        return view('dashboard.payments.coupons.index', compact('coupons'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.payments.coupons.form');
    }

    /**
     * @param CouponStore $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CouponStore $request)
    {
        $this->coupon->create($request->except(['_token']));

        Alert::success('Coupon successfully created')->flash();

        return redirect()->route('coupons.index')->with('alerts', Alert::all());
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $coupon = $this->coupon->retrieve($id);
        $coupon->delete();

        Alert::success('Coupon successfully deleted')->flash();

        return redirect()->route('coupons.index')->with('alerts', Alert::all());
    }
}