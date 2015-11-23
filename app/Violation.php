<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
