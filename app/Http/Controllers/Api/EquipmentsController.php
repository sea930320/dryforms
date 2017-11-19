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
    private $models;
    /**
     * @var Category
     */
    private $category;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Equipment $equipment
     * @param EquipmentModel    $models
     * @param Status    $status
     * @param Category  $category
     */
    public function __construct(Equipment $equipment, EquipmentModel $models, Status $status, Category $category, Team $team)
    {
        $this->equipment = $equipment;
        $this->models = $models;
        $this->status = $status;
        $this->category = $category;
        $this->team = $team;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = [];
        $categories = $this->category->get();
        $statuses = $this->status->get();

        foreach ($categories as $category) {
            foreach ($category->models as $model) {
                $response[$category->name][$model->name]['id'] = $model->id;
                $response[$category->name][$model->name]['total'] = $model->equipments->count();
                foreach ($statuses as $status) {
                    $response[$category->name][$model->name][$status->name] = $model->equipments->where('status_id', $status->id)->count();
                }
            }
        }

        return $this->respond($response);
    }

    /**
     * @param int $id Model id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $model = $this->models->findOrFail($id);

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
        $model = $this->models->findOrFail($request->get('model_id'));
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