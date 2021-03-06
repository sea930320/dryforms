<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToCompany
{
    /**
     * @param bool $excludeDeleted
     *
     * @return Builder
     */
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->where($this->getTable() . '.company_id', '=', auth()->user()->company_id);
    }
}