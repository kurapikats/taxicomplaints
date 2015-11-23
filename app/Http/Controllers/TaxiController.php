<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Taxi;

class TaxiController extends Controller
{
    public function home()
    {
        $data = Taxi::getCommonPageData();
        return view('layouts.master', $data);
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

        if (is_null($taxi))
        {
            return redirect('/')->with('message', 'Taxi not found');
        }

        $data = Taxi::getCommonPageData();

        return view('taxi.home', compact('taxi') + $data);
    }

}
