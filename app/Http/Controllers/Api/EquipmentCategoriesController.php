<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Categories\CategoryStore;
use App\Http\Requests\Categories\CategoryUpdate;
use App\Http\Requests\Categories\CategoryIndex;

use App\Models\Category;
use App\Models\Equipment;
use App\Services\QueryBuilder;
use App\Services\QueryBuilders\EquipmentCategoryQueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquipmentCategoriesController extends ApiController
{
    /**
     * @var Category
     */
    private $category;
    private $equipment;
    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Category $category
     * @param Equipment $equipment
     */
    public function __construct(Category $category, Equipment $equipment)
    {
        $this->category = $category;
        $this->equipment = $equipment;
    }

    /**
     * @param CategoryIndex $request
     *
     * @return JsonResponse
     */
    public function index(CategoryIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();
        $queryBuilder = new EquipmentCategoryQueryBuilder();
        $categories = $queryBuilder->setQuery($this->category->query())->setQueryParams($queryParams);
        $categories = $categories->paginate($request->get('per_page'));        
        return $this->respond($categories);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $category = $this->category->findOrFail($id);

        return $this->respond($category);
    }

    /**
     * @param CategoryStore $request
     *
     * @return JsonResponse
     */
    public function store(CategoryStore $request): JsonResponse
    {
        $category = $this->category->create([
            'name' => $request->get('name'),
            'prefix' => $request->get('prefix'),
            'description' => $request->get('description'),
            'company_id' => $request->get('company_id')
        ]);

        return $this->respond(['message' => 'Category successfully created', 'category' => $category]);
    }

    /**
     * @param CategoryUpdate $request
     *
     * @return JsonResponse
     */
    public function update(CategoryUpdate $request): JsonResponse
    {
        $category = $this->category->find($request->input('category_id'));
        $oldPrefix = $category->prefix;
        $oldPrefix = strlen($oldPrefix) > 0 ? $oldPrefix : "";
        $category->update($request->validated());
        $equipments = $category->equipments()->where('serial', 'REGEXP', "^$oldPrefix")->get();
        foreach ($equipments as $key => $equipment) {
            $newSerial = str_replace($oldPrefix, $request->input('prefix'), $equipment->serial);
            $this->equipment->where('id', $equipment->id)->update(['serial' => $newSerial]);
        }
        return $this->respond(['message' => 'Category successfully updated', 'category' => $category]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->category->findOrFail($id)->delete();
        return $this->respond(['message' => 'Category successfully deleted']);
    }

    /**
     * Get models by category id
     *
     * @param int $id
     *
     * @return  JsonResponse
     */
    public function getModels(int $id): JsonResponse
    {
        $category = $this->category->findOrFail($id);

        return $this->respond(['models' => $category->models]);
    }
}