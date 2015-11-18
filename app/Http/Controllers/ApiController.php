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

        if (count($taxi) > 0)
        {
            $data['taxi'] = $taxi;
            $data['taxi_pictures'] = $taxi->taxi_pictures();
            $data['taxi_complaints'] = $taxi->taxi_complaints();
            $data['taxi_violations'] = $taxi->taxi_violations();
            $data['violations'] = $taxi->violations();
            $data['uniq_violations'] = $taxi->uniqViolations();

            return response()->json(['data' => $data, 200]);
        }
        else
        {
            return response()->json(['message' => 'Not Found', 404]);
        }
    }

    public function search($keyword)
    {
        $taxis = Taxi::search($keyword);

        if (count($taxis) > 0)
        {
            return response()->json(['data' => $taxis, 200]);
        }
        else
        {
            return response()->json(['message' => 'Not Found', 404]);
        }
    }

    public function complaintValidate(Request $request)
    {
        $taxi_complaint = TaxiComplaint::find($request->taxi_complaint_id);
        $taxi_complaint->valid = $request->toggle;
        $taxi_complaint->save();

        return response()->json(['data' => $taxi_complaint->id, 200]);
    }

    public function sendMail(Request $request)
    {
        // generated, send email and update db record
        $taxi_complaint = TaxiComplaint::find($request->taxi_complaint_id);

        $mail = TaxiComplaint::sendMail($taxi_complaint);

        $taxi_complaint->mail_sent = $request->toggle;
        $taxi_complaint->save();

        return response()->json(['data' => $mail, 200]);
    }

    public function report(Request $request)
    {
        $user  = Auth::user();
        $rules = [
            'plate_number'  => 'required',
            'name'          => 'required',
            'incident_date' => 'required',
            'violations'    => 'required'
        ];

        // if not authenticated, add additional rules - for user account
        if (is_null($user))
        {
            $rules += [
                'email'                 => 'required|email',
                'full_name'             => 'required',
                'contact_number'        => 'required',
                'reg_password'          => 'required|confirmed'
            ];
        }

        // iterate on each pictures and add a valid rule
        $txp = count($request->taxi_pictures) - 1;
        foreach(range(0, $txp) as $index)
        {
            $rules['taxi_pictures.' . $index] = 'image';
        }

        $this->validate($request, $rules);

        $data = Taxi::store($request, $user);

        // db transaction (search) yielded to many results
        // redirect to search page using the plate_number as keyword
        if (!empty($data) && is_array($data) && isset($data['plate_number']))
        {
            // return redirect('search/' . $data['plate_number']);
            return response()->json(['data' => ['plate_number' =>
                $data['plate_number']], 200]);
        }

        // user is not logged-in, try auto login the current reporter
        if (is_null($user))
        {
            Auth::attempt([
                'email'    => $request->email,
                'password' => $request->password
            ]);
        }

        // return redirect('/');

        if (!empty($data) && is_array($data) && isset($data['taxi_id']))
        {
            return response()->json(['data' => ['taxi_id' =>
                $data['taxi_id']], 200]);
        }
        else
        {
            return response()->json(['message' => 'Failed add new report', 500]);
        }
    }
}
