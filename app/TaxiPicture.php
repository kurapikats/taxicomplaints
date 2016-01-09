<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Taxi Pictures, associate photos to a Taxi.
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class TaxiPicture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['taxi_id', 'taxi_complaint_id', 'path', 'description'];

}
