<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultFromData extends Model
{
    /**
     * @var string
     */
    public $table = 'default_forms_data';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'title',
        'additional_notes_show',
        'footer_text_show',
        'footer_text',
        'insured_signature',
        'company_signature'
    ];

    /**
     * @var array
     */
    public $visible = [
        'name',
        'title',
        'form_id',
        'additional_notes_show',
        'footer_text_show',
        'footer_text',
        'insured_signature',
        'company_signature',
        'default_statements'
    ];

    /**
     * Relation with default_statements.
     */
    public function default_statements()
    {
        return $this->hasMany(DefaultStatement::class, 'form_id', 'form_id');
    }
}