<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Equipments\EquipmentStore;
use App\Http\Requests\Equipments\EquipmentUpdate;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\EquipmentModel;
use App\Models\Status;
use App\Models\Team;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = $this->category->with([
            'models',
            'models.equipment',
            'models.equipment.team',
            'models.equipment.model',
            'models.equipment.status',
        ])->get();

        return $this->respond($categories);
    }

    /**
     * @param int $id Model id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $model = $this->model->findOrFail($id);

        return $this->respond($model->equipments);
    }

    /**
     * @param EquipmentStore $request
     *
     * @return JsonResponse
     */
    public function store(EquipmentStore $request): JsonResponse
    {
        $category = $this->category->findOrFail($request->get('category_id'));
        $model = $this->model->findOrFail($request->get('model_id'));
        $quantity = $request->get('quantity');

        $response = [];

        for($i = $model->equipments_count; $i < $quantity + $model->equipments_count; $i++) {

            // generate serial
            $serial = '#' . $category->prefix . str_pad($i, 4, '0', STR_PAD_LEFT);


            $response[] = $this->equipment->create([
                'model_id' =>  $request->get('model_id'),
                'team_id' => $request->get('model_id'),
                'serial' => $serial,
                'status_id' => $request->get('status_id'),
            ]);

        }

        return $this->respond(['message' => 'Equipments successfully created', 'equipments' => $response]);
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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        $this->equipment->whereIn('id', $request->get('ids'))->delete();

        return $this->respond(['message' => 'Equipments successfully deleted']);
    }
}