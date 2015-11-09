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

class TaxiController extends Controller
{
    public function home()
    {
        $top_violators = TaxiViolation::getTopViolators(10);
        $taxis = Taxi::orderBy('id', 'desc')->paginate(10);
        $violations = Violation::lists('name', 'id');
        return view('taxi.home', compact('taxis', 'top_violators', 'violations'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $taxis = Taxi::search($keyword);
        return view('taxi.home', compact('taxis'));
    }

    public function report()
    {
        $violations = Violation::lists('name', 'id');
        return view('taxi.report', compact('violations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($taxi_id)
    {
        $taxi = Taxi::find($taxi_id);

        if (is_null($taxi))
        {
            return redirect('report');
        }

        $violations = Violation::lists('name', 'id');
        return view('taxi.report', compact('violations', 'taxi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
                'password'              => 'required|confirmed'
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
            return redirect('search/' . $data['plate_number']);
        }

        if (is_null($user))
        {
            Auth::attempt([
                'email'    => $request->email,
                'password' => $request->password
            ]);
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $taxi_id
     * @return \Illuminate\Http\Response
     */
    public function show($taxi_id)
    {
        $taxi = Taxi::find($taxi_id);

        // $this->sendMail($taxi);

        if (is_null($taxi))
        {
            return redirect('report');
        }

        return view('taxi.view', compact('taxi'));
    }

    public function sendMail(TaxiComplaint $taxi_complaint)
    {
        $taxi           = $taxi_complaint->taxi();
        $reporter       = $taxi_complaint->user();
        $violations     = $taxi_complaint->violations();

        $data = [
            'taxi'       => $taxi,
            'reporter'   => $reporter,
            'violations' => $violations,
            'complaint'  => $taxi_complaint
        ];

        return view('emails.taxi-complaint', compact('data'));

        $target_email = config('app.taxi_complaint_email');
        $target_name  = config('app.taxi_complaint_name');

        // send url for full details of the complaints
        $mail = Mail::queue('emails.taxi-complaint', $data,
            function($message) use ($reporter) {
                $message->to($target_email, $target_name)
                ->from($reporter->email, $reporter->name)
                ->subject('Taxi Complaint - Plate #:' . $taxi->plate_number);
        });

        return $mail;
    }

    public function mail(Request $request)
    {
        $taxi_complaint = TaxiComplaint::find($request->taxi_complaint_id);
        return $this->sendMail($taxi_complaint);
    }

}
