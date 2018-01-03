<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Areas\AreaStore;
use App\Http\Requests\Areas\AreaUpdate;
use App\Models\Area;
use Illuminate\Http\JsonResponse;

class AreasController extends ApiController
{
    /**
     * @var Area
     */
    private $area;

    /**
     * AreasController constructor.
     *
     * @param Area $area
     */
    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $areas = $this->area
            ->where('company_id', auth()->user()->company->id)
            ->orWHere('type', 'system')
            ->paginate(20);

        return $this->respond($areas);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $area = $this->area
            ->where('company_id', auth()->user()->company->id)
            ->orWHere('type', 'system')
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
            'type' => $request->get('type'),
            'company_id' => $request->get('company_id'),
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
            ->where('company_id', auth()->user()->company->id)
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