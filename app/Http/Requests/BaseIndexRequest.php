<?php

namespace App\Http\Requests;

class BaseIndexRequest extends BaseRequest
{
    const PER_PAGE = 20;

    /**
     * @return array
     */
    public function validationData()
    {
        if (!$this->has('per_page')) {
            $this->merge(
                [
                    'per_page' => static::PER_PAGE
                ]
            );
        }

        return parent::validationData();
    }
}