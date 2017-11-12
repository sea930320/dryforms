<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Categories\CategoryStore;
use App\Http\Requests\Categories\CategoryUpdate;
use App\Models\Category;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquipmentCategoriesController extends ApiController
{
    /**
     * @var Category
     */
    private $category;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = $this->category->paginate(20);

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
            'prefix' => $request->get('prefix')
        ]);

        return $this->respond(['message' => 'Category successfully created', 'category' => $category]);
    }

    public function update(CategoryUpdate $request): JsonResponse
    {
        //TODO implement update
    }

    public function destroy(): JsonResponse
    {
        //TODO implement destroy
    }
}