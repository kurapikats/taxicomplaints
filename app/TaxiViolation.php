<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class TaxiViolation extends Model
{
    public function violation()
    {
        return $this->belongsTo('App\Violation')->first();
    }

    public static function getTopViolators($limit = 5)
    {
        $sql   = 'count(*) as counter, plate_number, taxis.id, taxis.name';
        $taxis = DB::table('taxi_violations')
            ->join('taxi_complaints', 'taxi_violations.taxi_complaint_id', '=',
                'taxi_complaints.id')
            ->join('taxis', 'taxi_complaints.taxi_id', '=', 'taxis.id')
            ->select(DB::raw($sql))
            ->groupBy('plate_number')
            ->orderBy('counter', 'desc')
            ->limit($limit)
            ->get();

        return $taxis;
    }
}
