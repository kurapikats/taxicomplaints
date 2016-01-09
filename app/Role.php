<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * User Roles, used to check if a particular user is allowed to access a feature.
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class Role extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Get all users that have this particular Role
     *
     * @return object List of Users associated to a Role
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
