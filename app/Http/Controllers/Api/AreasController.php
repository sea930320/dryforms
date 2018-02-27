<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Areas\AreasIndex;
use App\Http\Requests\Areas\AreaStore;
use App\Http\Requests\Areas\AreaUpdate;
use App\Models\Area;
use App\Models\DefaultArea;

use Illuminate\Http\JsonResponse;

class AreasController extends ApiController
{
    /**
     * @var Area
     */
    private $area;

    /**
     * @var DefaultArea
     */
    private $defaultArea;

    /**
     * AreasController constructor.
     *
     * @param Area $area
     * @param DefaultArea $defaultArea
     */
    public function __construct(Area $area, DefaultArea $defaultArea)
    {
        $this->area = $area;
        $this->defaultArea = $defaultArea;
    }

    /**
     * @param AreasIndex $request
     *
     * @return JsonResponse
     */
    public function index(AreasIndex $request): JsonResponse
    {
        if ($this->area->count() == 0) {
            $defaultAreas = $this->defaultArea->get();
            foreach ($defaultAreas as $key => $defaultArea) {
                $this->area->create([
                    'title' => $defaultArea['title'],
                    'company_id' => auth()->user()->company->id
                ]);
            }
        }
        $areas = $this->area->get();
        return $this->respond([
            'areas' => $areas
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $area = $this->area
            ->findOrFail($id);

        return $this->respond($area);
    }

    /**
     * @param AreaStore $request
     *
     * @return JsonResponse
     */
    public function store(AreaStore $request): JsonResponse
    {
        $area = $this->area->create([
            'title' => $request->get('title'),
            'company_id' => auth()->user()->company->id,
        ]);

        return $this->respond(['message' => 'Area successfully created', 'area' => $area]);
    }

    /**
     * @param AreaUpdate $request
     *
     * @return JsonResponse
     */
    public function update(AreaUpdate $request): JsonResponse
    {
        $area = $this->area
            ->findOrFail($request->input('area_id'));
        $area->update($request->validatedOnly());

        return $this->respond(['message' => 'Area successfully updated', 'area' => $area]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->area->findOrFail($id)->delete();

        return $this->respond(['message' => 'Area successfully deleted']);
    }
}