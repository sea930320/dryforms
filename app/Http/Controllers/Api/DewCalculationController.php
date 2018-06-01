<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Dew\CalculateRequest;
use App\Services\Dew\CalculationService;

class DewCalculationController extends ApiController
{
    /**
     * @var CalculationService
     */
    private $service;

    /**
     * DewCalculationController constructor.
     *
     * @param CalculationService $service
     */
    public function __construct(CalculationService $service)
    {
        $this->service = $service;
    }

    /**
     * @param CalculateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(CalculateRequest $request)
    {
        return response()->json([
            'result' => $this->service->calculate($request->get('temperature'), $request->get('rh'))
        ]);
    }
}