<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class QueryBuilder
{
    /**
     * @var Model
     */
    private $query;

    public function setQuery(Builder $query): QueryBuilder
    {
        $this->query = $query;

        return $this;
    }
// TODO Extend
    public function setQueryParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->query->where($key, $value);
        }

        return $this->query;
    }
}