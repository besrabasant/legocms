<?php

namespace LegoCMS\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LegoCMS\Models\Behaviours\IsTranslatable;

/**
 * Class User
 *
 * @category Models
 * @package  LegoCMS\Models
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Models/User.php
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, MustVerifyEmail, IsTranslatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = [
        'name', 'email', 'role', 'published'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var  array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var  array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * __contruct
     *
     * @param  array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = \config('legocms.users_table', 'legocms_users');

        parent::__construct($attributes);
    }

    /**
     * Scope excludeSuperAdmin.
     *
     * @param  Builder $query
     *
     * @return  Builder
     */
    public function scopeExcludeSuperAdmin($query)
    {
        return $query->where('role', '<>', 'SUPERADMIN');
    }

    /**
     * Checks if user is Super Admin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->getAttribute('role') === 'SUPERADMIN';
    }
}
