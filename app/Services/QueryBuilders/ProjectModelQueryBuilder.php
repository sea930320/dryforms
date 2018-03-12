<?php

namespace App\Services\QueryBuilders;

use App\Services\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProjectModelQueryBuilder extends QueryBuilder
{
    /**
     * @param array $params
     *
     * @return Builder
     */
    public function setQueryParams(array $params): Builder
    {
        if (isset($params['status'])) {
            $this->query->whereHas('status_info', function ($query) use ($params) {
                $query->where('id', $params['status']);
            });
        }
        if (isset($params['filter'])) {
            $filter = $params['filter'];
            $this->query->where(function($query) use ($filter) {
                $query
                    ->whereHas('owner', function ($query) use ($filter) {
                        $query->where('first_name', 'like', "%$filter%")
                            ->orWhere('last_name', 'like', "%$filter%");
                    })
                    ->orWhereHas('assignee', function($query) use ($filter) {
                        $query->where('name', 'like', "%$filter%");
                    })
                    ->orWhere('address', 'like', "%$filter%%")
                    ->orWhere('phone', 'like', "%$filter%%");
                });
        }
        if (isset($params['year'])) {
            // $this->query->whereHas('category', function ($query) use ($params) {
            //     $query->where('name', 'like', "%{$params['category_name']}%");
            // });
        }
        $this->query->orderBy('id', 'desc');
        return $this->query;
    }
}