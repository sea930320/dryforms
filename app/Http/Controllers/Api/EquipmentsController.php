<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Equipments\EquipmentIndex;
use App\Http\Requests\Equipments\EquipmentStore;
use App\Http\Requests\Equipments\EquipmentUpdate;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\EquipmentModel;
use App\Models\Status;
use App\Models\Team;
use App\Services\QueryBuilder;
use App\Services\QueryBuilders\EquipmentQueryBuilder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquipmentsController extends ApiController
{
    /**
     * @var Equipment
     */
    private $equipment;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var EquipmentModel
     */
    private $model;

    /**
     * @var Category
     */
    private $category;

    /**
     * EquipmentsController constructor.
     *
     * @param Equipment $equipment
     * @param EquipmentModel $model
     * @param Status $status
     * @param Category $category
     * @param Team $team
     */
    public function __construct(
        Equipment $equipment,
        EquipmentModel $model,
        Status $status,
        Category $category,
        Team $team
    ) {
        $this->equipment = $equipment;
        $this->model = $model;
        $this->status = $status;
        $this->category = $category;
        $this->team = $team;
    }

    /**
     * @param EquipmentIndex $request
     *
     * @return JsonResponse
     */
    public function index(EquipmentIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();
        $equipments = $this->equipment->with([            
            'team',
            'status',
            'model',
            'model.category'
        ]);
        $queryBuilder = new EquipmentQueryBuilder();
        $equipments = $queryBuilder->setQuery($equipments)->setQueryParams($queryParams);

        $equipments = $equipments->paginate($request->get('per_page'));

        return $this->respond($equipments);
    }

    /**
     * @param int $id Model id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $equipment = $this->equipment->with([
            'model.category',
            'team',
            'status'
        ])->findOrFail($id);

        return $this->respond($equipment);
    }

    /**
     * @param EquipmentStore $request
     *
     * @return JsonResponse
     */
    public function store(EquipmentStore $request): JsonResponse
    {
        $categoryPrefix = $this->category->find($request->get('category_id'))->prefix;
        $equipment = $this->equipment->create([
            'model_id' => $request->get('model_id'),
            'team_id' => $request->get('team_id'),
            'serial' => $categoryPrefix . ' ' . $request->get('serial'),
            'status_id' => $request->get('status_id'),
            'company_id' => $request->get('company_id'),
        ]);

        $equipment->load(['model.category', 'status', 'team']);

        return $this->respond(['message' => 'Equipments successfully created', 'equipment' => $equipment]);
    }

    /**
     * @param EquipmentUpdate $request
     *
     * @return JsonResponse
     */
    public function update(EquipmentUpdate $request)
    {
        $equipment = $this->equipment->find($request->input('equipment_id'));
        $equipment->update($request->validatedOnly());
        $equipment->load(['model.category', 'status', 'team']);

        return $this->respond(['message' => 'Equipment successfully updated', 'equipment_id' => $equipment]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->equipment->findOrFail($id)->delete();

        return $this->respond(['message' => 'Equipment successfully deleted']);
    }
}