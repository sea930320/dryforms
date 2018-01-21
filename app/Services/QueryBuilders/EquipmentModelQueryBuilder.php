<?php

namespace App\Services\QueryBuilders;

use App\Services\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Status;

class EquipmentModelQueryBuilder extends QueryBuilder
{
    /**
     * EquipmentModelQueryBuilder constructor.
     *
     * @param Status $status
     */
    public function __construct()
    {
        $this->status = new Status;
    }

    /**
     * @param array $params
     *
     * @return Builder
     */
    public function setQueryParams(array $params): Builder
    {
        if (isset($params['category_id'])) {
            $this->query->whereHas('category', function ($query) use ($params) {
                $query->where('id', $params['category_id']);
            });
        }
        if (isset($params['category_name'])) {
            $this->query->whereHas('category', function ($query) use ($params) {
                $query->where('name', 'like', "%{$params['category_name']}%");
            });
        }
        if (isset($params['model_name'])) {
            $this->query->where('equipment_models.name', 'like', "%{$params['model_name']}%");
        }

        if (isset($params['sort_by'])) {
            $sort_type = isset($params['sort_type']) ? $params['sort_type'] : 'asc';
            $sort_by = $params['sort_by'];
            if ($sort_by == "category_name") {
                $this->query->join('equipment_categories', 'category_id', '=','equipment_categories.id')->select('equipment_models.*')->orderBy("equipment_categories.name", $sort_type);
            } else if ($sort_by == "make_model") {
                $this->query->orderBy("name", $sort_type);
            } else {
                $this->query->orderBy($sort_by, $sort_type);
            }         
        }
        
        $statuses = $this->status->get();
        foreach ($statuses as $key => $status) {
            $alias_status = 'equipment as status_'. $status->id. '_count';
            $this->query->withCount([
                $alias_status => function($query) use ($status) {
                    $query->where('status_id', $status->id);
                }
            ]);            
        }
        return $this->query;
    }
}