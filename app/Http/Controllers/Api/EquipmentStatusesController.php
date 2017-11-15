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

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $team = $this->status->findOrFail($id);

        return $this->respond($team);
    }

    /**
     * @param StatusStore $request
     *
     * @return JsonResponse
     */
    public function store(StatusStore $request): JsonResponse
    {
        $team = $this->status->create([
            'name' => $request->get('name')
        ]);

        return $this->respond(['message' => 'Status successfully created', 'team' => $team]);
    }

    /**
     * @param StatusUpdate $request
     *
     * @return JsonResponse
     */
    public function update(StatusUpdate $request): JsonResponse
    {
        $status = $this->status->find($request->input('status_id'));
        $status->update($request->validatedOnly());

        return $this->respond(['message' => 'Status successfully updated', 'status' => $status]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->status->findOrFail($id)->delete();

        return $this->respond(['message' => 'Status successfully deleted']);
    }
}