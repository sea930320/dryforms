<?php

namespace App\Http\Controllers\Api;

use App\Models\UnitOfMeasure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UomsController extends ApiController
{
    /**
     * @var UnitOfMeasure
     */
    private $uom;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param UnitOfMeasure $uom
     */
    public function __construct(UnitOfMeasure $uom)
    {
        $this->uom = $uom;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
    	$uoms = $this->uom->get();
        return $this->respond(['uoms' => $uoms]);
    }
}
