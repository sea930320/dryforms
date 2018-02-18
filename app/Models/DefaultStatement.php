<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultStatement extends Model
{
    /**
     * @var string
     */
    public $table = 'default_statements';

    /**
     * @var array
     */
    public $fillable = [
        'form_id',
        'title',
        'statement',
    ];

    /**
     * @var array
     */
    public $visible = [
        'form_id',
        'title',
        'statement'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
