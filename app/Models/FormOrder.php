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
    public $visible = ['id', 'company_id', 'form_id', 'form', 'company', 'default_forms_data', 'standard_form', 'standard_statement', 'default_statements'];

    /**
     * Relation with forms.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

	/**
     * Relation with default_forms_data.
     */
    public function default_forms_data()
    {
        return $this->hasOne(DefaultFromData::class, 'form_id', 'form_id');
    }

    /**
     * Relation with default_statements.
     */
    public function default_statements()
    {
        return $this->hasOne(DefaultStatement::class, 'form_id', 'form_id');
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

    /**
     * Relation with standard_statements.
     */
    public function standard_statement()
    {
        return $this->hasMany(StandardStatement::class, 'form_id', 'form_id');
    }
}
