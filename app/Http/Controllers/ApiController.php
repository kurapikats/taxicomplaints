<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Mail;
use Validator;
use App\User;
use App\Violation;
use App\Taxi;
use App\TaxiComplaint;
use App\TaxiViolation;
use App\TaxiPicture;

class ApiController extends Controller
{
    public function show($taxi_id)
    {
        $taxi = Taxi::find($taxi_id);

        if (count($taxi) > 0) {
            $data['taxi'] = $taxi;
            $data['taxi_pictures'] = $taxi->taxi_pictures();
            $data['taxi_complaints'] = $taxi->taxi_complaints();
            $data['taxi_violations'] = $taxi->taxi_violations();
            $data['violations'] = $taxi->violations();
            $data['uniq_violations'] = $taxi->uniqViolations();

            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['message' => 'Not Found', 404]);
        }
    }

    public function search($keyword)
    {
        $taxis = Taxi::search($keyword);

        if (count($taxis) > 0) {
            return response()->json(['data' => $taxis, 200]);
        } else {
            return response()->json(['message' => 'Not Found', 404]);
        }
    }
}
