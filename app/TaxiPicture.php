<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiPicture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['taxi_id', 'taxi_complaint_id', 'path', 'description'];

}
