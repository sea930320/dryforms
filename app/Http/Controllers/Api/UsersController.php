<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Users\UserStore;
use App\Http\Requests\Users\UserUpdate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Hashing\Hasher;

class UsersController extends ApiController
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * UsersController constructor.
     *
     * @param User $user
     * @param Team $team
     * @param Hasher $hasher
     */
    public function __construct(User $user, Team $team, Hasher $hasher)
    {
        $this->user = $user;
        $this->team = $team;
        $this->hasher = $hasher;
    }

    public function index(): JsonResponse
    {
        $users = $this->user->with(['role', 'teams'])
            ->where('company_id', auth()->user()->company_id)
            ->paginate(20);

        return $this->respond($users);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->user
            ->with(['role', 'teams'])
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($id);
        return $this->respond($user);
    }

    /**
     * @param UserStore $request
     *
     * @return JsonResponse
     */
    public function store(UserStore $request): JsonResponse
    {
        $userData = $request->validatedOnly();
        $teamId = "";
        if (isset($userData['team_id'])) {
            $teamId = $userData['team_id'];
            unset($userData['team_id']);
        }
        $password = $this->hasher->make(str_random(12));
        $userData['password'] = $password;
//TODO send email with password
        $user = $this->user->create($userData);
        if ($teamId) {
            $user->teams()->attach($teamId);
        }

        return $this->respond(['message' => 'User successfully created', 'user' => $user]);
    }

    /**
     * @param UserUpdate $request
     *
     * @return JsonResponse
     */
    public function update(UserUpdate $request): JsonResponse
    {
        $userData = $request->validatedOnly();
        $teamId = "";
        if (isset($userData['team_id'])) {
            $teamId = $userData['team_id'];
            unset($userData['team_id']);
        }
        $user = $this->user->find($request->input('id'));
        $user->update($userData);
        if ($teamId) {
            $user->teams()->sync($teamId);
        }
        else {
            $user->teams()->detach();
        }
        return $this->respond(['message' => 'User successfully updated', 'user' => $user]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->user->findOrFail($id)->delete();
        return $this->respond(['message' => 'User successfully deleted']);
    }
}