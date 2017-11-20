<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Statuses\StatusStore;
use App\Http\Requests\Statuses\StatusUpdate;
use App\Models\Status;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquipmentStatusesController extends ApiController
{
    /**
     * @var Status
     */
    private $status;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Status $status
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $statuses = $this->status->paginate(20);

        return $this->respond($statuses);
    }
}