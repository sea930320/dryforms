<?php

namespace App\Services\QueryBuilders;

use App\Services\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class EquipmentCategoryQueryBuilder extends QueryBuilder
{
    /**
     * @param array $params
     *
     * @return Builder
     */
    public function setQueryParams(array $params): Builder
    {
        if (isset($params['filter'])) {
            $this->query->where(function($query) use ($params) {
                $query->where(
                    'name', 'like', "%{$params['filter']}%"
                )->orWhere(
                    'prefix', 'like', "%{$params['filter']}%"
                )->orWhere(
                    'description', 'like', "%{$params['filter']}%"
                );
            });
        }
        if (isset($params['sort_by'])) {
            $sort_type = isset($params['sort_type']) ? $params['sort_type'] : 'asc';
            $sort_by = $params['sort_by'];
            $this->query->orderBy($sort_by, $sort_type);
        }
        return $this->query;
    }
}