<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Models\ModelStore;
use App\Http\Requests\Models\ModelUpdate;
use App\Http\Requests\Models\ModelIndex;

use App\Models\EquipmentModel;
use App\Services\QueryBuilder;
use App\Services\QueryBuilders\EquipmentModelQueryBuilder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquipmentModelsController extends ApiController
{
    /**
     * @var EquipmentModel
     */
    private $model;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param EquipmentModel $model
     */
    public function __construct(EquipmentModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param ModelIndex $request
     *
     * @return JsonResponse
     */
    public function index(ModelIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();
        $models = $this->model->with(['category']);
        $queryBuilder = new EquipmentModelQueryBuilder();
        $models = $queryBuilder->setQuery($models)->setQueryParams($queryParams);

        $models = $models->paginate($request->get('per_page'));

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
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'description' => $request->input('description'),
            'company_id' => $request->input('company_id')
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