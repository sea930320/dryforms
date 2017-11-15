<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Models\ModelStore;
use App\Http\Requests\Models\ModelUpdate;
use App\Models\Models;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquipmentModelsController extends ApiController
{
    /**
     * @var Models
     */
    private $model;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Models $model
     */
    public function __construct(Models $model)
    {
        $this->model = $model;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $models = $this->model->paginate(20);

        return $this->respond($models);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $models = $this->model->findOrFail($id);

        return $this->respond($models);
    }

    /**
     * @param ModelStore $request
     *
     * @return JsonResponse
     */
    public function store(ModelStore $request): JsonResponse
    {
        $model = $this->model->create([
            'name' => $request->get('name'),
            'category_id' => $request->get('category_id')
        ]);

        return $this->respond(['message' => 'Model successfully created', 'model' => $model]);
    }

    /**
     * @param ModelUpdate $request
     *
     * @return JsonResponse
     */
    public function update(ModelUpdate $request): JsonResponse
    {
        $model = $this->model->find($request->input('model_id'));
        $model->update($request->validatedOnly());

        return $this->respond(['message' => 'Model successfully updated', 'model' => $model]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->model->findOrFail($id)->delete();

        return $this->respond(['message' => 'Model successfully deleted']);
    }
}