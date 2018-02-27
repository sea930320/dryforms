<?php
namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use BelongsToCompany;
    /**
     * @var string
     */
    public $table = 'areas';

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