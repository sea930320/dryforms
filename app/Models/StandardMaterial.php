<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class StandardMaterial extends Model
{
    use BelongsToCompany;
    /**
     * @var string
     */
    public $table = 'standard_materials';

    /**
     * @var array
     */
    public $fillable = ['title', 'type', 'company_id'];

    /**
     * @var array
     */
    public $visible = [
        'id',
        'title',
        'company_id'
    ];
}
