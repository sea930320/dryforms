<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class ApiAuthController extends LoginController
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var JWTAuth
     */
    private $jwtAuth;

    /**
     * ApiLoginController constructor.
     *
     * @param User $user
     * @param JWTAuth $jwtAuth
     */
    public function __construct(User $user, JWTAuth $jwtAuth)
    {
        parent::__construct();
        $this->user = $user;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = $this->jwtAuth->attempt($credentials);

            if (!$token) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Failed to create token'
            ], 401);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        return response()->json([
            'message' => 'Success',
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser(){
        $user = $this->jwtAuth->toUser();

        return response()->json(['result' => $user]);
    }
}