<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Companies\CompanyStore;
use App\Http\Requests\Companies\CompanyUpdate;
use App\Models\Company;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\File;

class CompaniesController extends ApiController
{
    /**
     * @var Company
     */
    private $company;

    private $user;

    /**
     * CompaniesController constructor.
     *
     * @param Company $company
     */
    public function __construct(Company $company, User $user)
    {
        $this->company = $company;
        $this->user = $user;
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
        $storagePath = storage_path('app/public/settings');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0775);
        }
        $logoPath = ($storagePath . '/logo');
        if (!File::exists($logoPath)) {
            File::makeDirectory($logoPath, 0775);
        }

        $success = true;        
        $logoImg = $request->input('logo');
        if ($logoImg) {
            $logoName = Uuid::generate();
            $logoImg = substr($logoImg, strpos($logoImg, ",")+1);
            $logoDecode = base64_decode($logoImg);
            $success = file_put_contents($logoPath. '/'. $logoName, $logoDecode);
        }
        if (!$success) 
        {
            return $this->respondWithError([
                'message' => 'Something wrong'
            ],
                422
            );
        }

        $company = $this->company->create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'logo' => $logoName,
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'cloud_link' => $request->input('cloud_link')
        ]);
        $user = $this->user->where('id', $request->input('user_id'))->first();
        $user->company_id = $company->id;
        $user->save();
        return $this->respond(['message' => 'Company successfully created', 'company' => $company, 'user' => $user]);
    }

    /**
     * @param CompanyUpdate $request
     *
     * @return JsonResponse
     */
    public function update(CompanyUpdate $request): JsonResponse
    {
        $request_params = $request->validatedOnly();
        $company = $this->company->find($request_params['company_id']);
        $storagePath = storage_path('app/public/settings');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0775);
        }
        $logoPath = ($storagePath . '/logo');
        if (!File::exists($logoPath)) {
            File::makeDirectory($logoPath, 0775);
        }

        // $oldLogoName = $company->logo;
        // if ($oldLogoName) {
        //     if (File::exists($logoPath. '/'. $oldLogoName)) {
        //         File::delete($logoPath. '/'. $oldLogoName);
        //     }
        // }
        $success = true;
        
        $logoImg = $request_params['logo'];
        if ($logoImg) {
            $newLogoName = Uuid::generate();
            $logoImg = substr($logoImg, strpos($logoImg, ",")+1);
            $logoDecode = base64_decode($logoImg);
            $success = file_put_contents($logoPath. '/'. $newLogoName, $logoDecode);
            $request_params['logo'] = $newLogoName;
        }        

        if ($success) {            
            $company->update($request_params);
            $company = $this->company->find($request_params['company_id']);
            return $this->respond(['message' => 'Company successfully updated', 'company' => $company]);
        } else {
            return $this->respondWithError([
                'message' => 'Something wrong'
            ],
                422
            );
        }
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