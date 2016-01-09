<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * Taxi Violations
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class TaxiViolation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['taxi_complaint_id', 'violation_id'];

    /**
     * Get all Violations associated to the current Taxi instance.
     */
    public function violation()
    {
        return $this->belongsTo('App\Violation')->first();
    }

    /**
     * Get Top Taxi Violators
     *
     * @param int $limit Number of limit to get, defaults to 5
     *
     * @return object List of Top Taxi Violators
     */
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
