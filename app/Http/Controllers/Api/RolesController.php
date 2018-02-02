<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;

class RolesController extends ApiController
{
    /**
     * @var Role
     */
    private $role;

    /**
     * RolesController constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->role->where('id', '!=', Role::SUPER_ADMIN)->paginate(20);

        return $this->respond($roles);
    }
}