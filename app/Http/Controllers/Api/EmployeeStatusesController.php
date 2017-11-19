<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\EmployeeStatuses\EmployeeStatusStore;
use App\Http\Requests\EmployeeStatuses\EmployeeStatusUpdate;
use App\Models\EmployeeStatus;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmployeeStatusesController extends ApiController
{
    /**
     * @var EmployeeStatus
     */
    private $employeeStatus;

    /**
     * EmployeeStatusesController constructor.
     *
     * @param EmployeeStatus $employeeStatus
     */
    public function __construct(EmployeeStatus $employeeStatus)
    {
        $this->employeeStatus = $employeeStatus;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $employeeStatuses = $this->employeeStatus->paginate(20);

        return $this->respond($employeeStatuses);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $employeeStatus = $this->employeeStatus->findOrFail($id);

        return $this->respond($employeeStatus);
    }

    /**
     * @param EmployeeStatusStore $request
     *
     * @return JsonResponse
     */
    public function store(EmployeeStatusStore $request): JsonResponse
    {
        $employeeStatus = $this->employeeStatus->create([
            'name' => $request->input('name')
        ]);

        return $this->respond(['message' => 'Employee status successfully created', 'status' => $employeeStatus]);
    }

    /**
     * @param EmployeeStatusUpdate $request
     *
     * @return JsonResponse
     */
    public function update(EmployeeStatusUpdate $request): JsonResponse
    {
        $employeeStatus= $this->employeeStatus->find($request->input('id'));
        $employeeStatus->update($request->validatedOnly());

        return $this->respond(['message' => 'Employee status successfully updated', 'status' => $employeeStatus]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->employeeStatus->findOrFail($id)->delete();

        return $this->respond(['message' => 'Status successfully deleted']);
    }
}