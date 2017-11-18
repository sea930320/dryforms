<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\CompanyEmployees\CompanyEmployeesStore;
use App\Http\Requests\CompanyEmployees\CompanyEmployeesUpdate;
use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompanyEmployeesController extends ApiController
{
    /**
     * @var CompanyEmployee
     */
    private $companyEmployee;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Role
     */
    private $role;

    /**
     * @var Company
     */
    private $company;

    /**
     * CompanyEmployeesController constructor.
     *
     * @param CompanyEmployee $companyEmployee
     * @param User            $user
     * @param Role            $role
     * @param Company         $company
     */
    public function __construct(CompanyEmployee $companyEmployee, User $user, Role $role, Company $company)
    {
        $this->companyEmployee = $companyEmployee;
        $this->user = $user;
        $this->role = $role;
        $this->company = $company;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function index(Request $request): JsonResponse
    {
        if( ! $company = $this->company->where('id', $request->input('company_id'))->first()) {
            return $this->respondWithError(['Company not found']);
        }

        $employees = [];
        foreach ($company->employees as $employee) {
            $employees[] = [
                'id' => $employee->id,
                'name' => $employee->user->name,
                'email' => $employee->user->email,
                'role' => $employee->user->roles->first()->name,
                'status' => $employee->status->name
            ];
        }

        $employees = new Paginator($employees, 5);

        return $this->respond($employees);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $employee = $this->companyEmployee->findOrFail($id);

        $response = [
            'name' => $employee->user->name,
            'email' => $employee->user->email,
            'role' => $employee->user->roles->first()->name,
            'status' => $employee->status->name,
        ];

        return $this->respond($response);
    }

    /**
     * @param CompanyEmployeesStore $request
     *
     * @return JsonResponse
     */
    public function store(CompanyEmployeesStore $request): JsonResponse
    {
        $role = $this->role->findOrFail($request->input('role_id'));

        $user = $this->user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $user->assignRole($role->name);

        $employee = $this->companyEmployee->create([
            'user_id' => $user->id,
            'company_id' => $request->input('company_id'),
            'status_id' => $request->input('status_id'),
        ]);

        $response = [
            'id' => $employee->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->first()->name,
            'status' => $user->employee->status->name,
        ];

        return $this->respond(['message' => 'Employee successfully created', 'employee' => $response]);
    }

    /**
     * @param CompanyEmployeesUpdate $request
     *
     * @return JsonResponse
     */
    public function update(CompanyEmployeesUpdate $request): JsonResponse
    {
        $employee = $this->companyEmployee->findOrFail($request->input('id'));
        $employee->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        $role = $this->role->findOrFail($request->input('role_id'));

        if($role) {
            $employee->user->removeRole($employee->user->roles->first()->name);
            $employee->user->assignRole($role->name);
        }

        $employee->update([
            'status_id' => $request->input('status_id'),
            'company_id' => $request->input('company_id'),
        ]);

        return $this->respond(['message' => 'Employee successfully updated', 'employee' => $employee]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->companyEmployee->findOrFail($id)->delete();

        return $this->respond(['message' => 'Employee successfully deleted']);
    }
}