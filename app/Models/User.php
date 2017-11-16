<?php

namespace App\Models;

use Backpack\PermissionManager\app\Models\Permission;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\CrudTrait;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable
{
    use Notifiable, Billable, CrudTrait, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $value
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return date("m/d/Y H:m", strtotime($value));
    }
}
