<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Companies\CompanyStore;
use App\Http\Requests\Companies\CompanyUpdate;
use App\Models\Company;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompaniesController extends ApiController
{
    /**
     * @var Company
     */
    private $company;

    /**
     * CompaniesController constructor.
     *
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = $this->company->paginate(20);

        return $this->respond($companies);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $company = $this->company->findOrFail($id);

        return $this->respond($company);
    }

    /**
     * @param CompanyStore $request
     *
     * @return JsonResponse
     */
    public function store(CompanyStore $request): JsonResponse
    {
        $company = $this->company->create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'logo' => $request->input('logo'),
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'cloud_link' => $request->input('cloud_link')
        ]);

        return $this->respond(['message' => 'Company successfully created', 'company' => $company]);
    }

    /**
     * @param CompanyUpdate $request
     *
     * @return JsonResponse
     */
    public function update(CompanyUpdate $request): JsonResponse
    {
        $company = $this->company->find($request->input('company_id'));
        $company->update($request->validatedOnly());

        return $this->respond(['message' => 'Company successfully updated', 'category' => $company]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->company->findOrFail($id)->delete();

        return $this->respond(['message' => 'Company successfully deleted']);
    }
}