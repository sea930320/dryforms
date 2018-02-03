<?php

namespace App\Services\QueryBuilders;

use App\Services\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class SettingsTeamQueryBuilder extends QueryBuilder
{
    /**
     * @param array $params
     *
     * @return Builder
     */
    public function setQueryParams(array $params): Builder
    {
        if (isset($params['sort_by'])) {
            $sort_type = isset($params['sort_type']) ? $params['sort_type'] : 'asc';
            $sort_by = $params['sort_by'];
            $this->query->orderBy($sort_by, $sort_type);
        }
        return $this->query;
    }
}