<?php

namespace App\Services\QueryBuilders;

use App\Services\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class EquipmentQueryBuilder extends QueryBuilder
{
    /**
     * @param array $params
     *
     * @return Builder
     */
    public function setQueryParams(array $params): Builder
    {
        if (isset($params['category_id'])) {
            $this->query->whereHas('equipments', function ($query) use ($params) {
                $query->where('category_id', $params['category_id']);
            });
        }
        if (isset($params['status_id'])) {
            $this->query->whereHas('equipments', function ($query) use ($params) {
                $query->where('status_id', $params['status_id']);
            });
        }
        if (isset($params['model_id'])) {
            $this->query->whereHas('equipments', function ($query) use ($params) {
                $query->where('model_id', $params['model_id']);
            });
        }
        if (isset($params['team_id'])) {
            $this->query->whereHas('equipments', function ($query) use ($params) {
                $query->where('team_id', $params['team_id']);
            });
        }

        if (isset($params['category_name'])) {
            $this->query->where('name', 'like', "%{$params['category_name']}%");
        }
        if (isset($params['model_name'])) {
            $this->query->whereHas('equipments.model', function ($query) use ($params) {
                $query->where('name', 'like', "%{$params['model_name']}%");
            });
        }
        if (isset($params['status'])) {
            $this->query->where('status', $params['status']);
        }
        if (isset($params['total'])) {
            $this->query->where('total', $params['total']);
        }

        $this->query->orderBy(
            isset($params['sort_by']) ? $params['sort_by'] : 'name',
            isset($params['sort_type']) ? isset($params['sort_type']) : 'asc'
        );

        return $this->query;
    }
}