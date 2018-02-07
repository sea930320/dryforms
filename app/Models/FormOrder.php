<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOrder extends Model
{
    /**
     * @var string
     */
    public $table = 'form_orders';

    /**
     * @var array
     */
    public $fillable = ['company_id', 'form_id'];

    /**
     * @var array
     */
    public $visible = ['id', 'company_id', 'form_id', 'form', 'company', 'standard_form'];

    /**
     * Relation with forms.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Relation with companies.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation with standard_forms.
     */
    public function standard_form()
    {
        return $this->hasMany(StandardForm::class, 'form_id', 'form_id');
    }
}
