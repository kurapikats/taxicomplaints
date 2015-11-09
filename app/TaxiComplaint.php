<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiComplaint extends Model
{
    public function taxi()
    {
        return $this->belongsTo('App\Taxi')->first();
    }

    public function taxi_violations()
    {
        return $this->hasMany('App\TaxiViolation')->get();
    }

    public function violations()
    {
        $violations = [];
        $taxi_violations = $this->taxi_violations();
        foreach ($taxi_violations as $v) {
            $violations[] = $v->violation();
        }
        return $violations;
    }

    public function pictures()
    {
        return $this->taxi()->taxi_pictures();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by')->first();
    }

    /**
     *
     *
     */
    public function isValid()
    {
        $data = 'Unchecked';

        if (!is_null($this->valid))
        {
            if ($this->valid == 1)
            {
                $data = 'True';
            }
            else
            {
                $data = 'False';
            }
        }

        return $data;
    }

    public function mailSent()
    {
        $data = 'False';

        if ($data == 1)
        {
            $data = 'True';
        }

        return $data;
    }
}
