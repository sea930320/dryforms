<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Account\ChangeEmailRequest;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Auth\AuthManager;

class AccountController extends ApiController
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * AccountController constructor.
     *
     * @param User $user
     * @param Hasher $hasher
     * @param AuthManager $authManager
     */
    public function __construct(User $user, Hasher $hasher, AuthManager $authManager)
    {
        $this->user = $user;
        $this->hasher = $hasher;
        $this->authManager = $authManager;
    }

    /**
     * @param ChangePasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $this->authManager->user();
        $user->fill(['password' => $this->hasher->make($request->get('new_password'))]);
        $user->save();

        return $this->respond(['message' => 'Password was successfully changed']);
    }

    /**
     * @param ChangeEmailRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeEmail(ChangeEmailRequest $request)
    {
        $user = $this->user->where('email', $request->get('old_email'))->first();
        $user->email = $request->get('new_email');
        $user->save();

        return $this->respond(['message' => 'Email was successfully changed']);
    }
}