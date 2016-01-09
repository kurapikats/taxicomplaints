<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Violations, storage for all available violations that can be reported.
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class Violation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

}
