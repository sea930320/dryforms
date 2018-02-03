<?php
namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements Repository
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getList(array $params, int $page, int $perPage, ?array $with = [])
    {
        $query = $this->model;

        foreach ($params as $param => $value) {
            $query->where($param, $value);
        }

        return $query->paginate($perPage);
    }
}