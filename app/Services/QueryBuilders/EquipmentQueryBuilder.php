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
            $this->query->whereHas('model', function ($query) use ($params) {
                $query->where('category_id', $params['category_id']);
            });
        }
        if (isset($params['status_id'])) {
            $this->query->where('status_id', $params['status_id']);
        }
        if (isset($params['model_id'])) {
            $this->query->where('model_id', $params['model_id']);
        }
        if (isset($params['team_id'])) {
            $this->query->where('team_id', $params['team_id']);
        }
        if (isset($params['filter'])) {
            $this->query->where(function($query) use ($params) {
                $query->where(
                    'location', 'like', "%{$params['filter']}%"
                )->orWhere(
                    'serial', 'like', "%{$params['filter']}%"
                )->orWhereHas('model', function ($query) use ($params) {
                    $query->where('name', 'like', "%{$params['filter']}%");
                    $query->orWhereHas('category', function ($query_cat) use ($params) {
                        $query_cat->where('name', 'like', "%{$params['filter']}%");
                    });
                })->orWhereHas('team', function ($query) use ($params) {
                    $query->where('name', 'like', "%{$params['filter']}%");
                })->orWhereHas('status', function ($query) use ($params) {
                    $query->where('name', 'like', "%{$params['filter']}%");
                });
            });
        }

        if (isset($params['sort_by'])) {
            $sort_type = isset($params['sort_type']) ? $params['sort_type'] : 'asc';
            $sort_by = $params['sort_by'];
            if ($sort_by == "make_model") {
                $this->query->join('equipment_models', 'model_id', '=','equipment_models.id')->select('equipments.*')->orderBy("equipment_models.name", $sort_type);
            } else if ($sort_by == "team") {
                $this->query->join('teams', 'team_id', '=','teams.id')->select('equipments.*')->orderBy("teams.name", $sort_type);
            } else if ($sort_by == "status") {
                $this->query->join('equipment_statuses', 'status_id', '=','equipment_statuses.id')->select('equipments.*')->orderBy("equipment_statuses.name", $sort_type);
            } else {
                $this->query->orderBy($sort_by, $sort_type);
            }
        }

        return $this->query;
    }
}