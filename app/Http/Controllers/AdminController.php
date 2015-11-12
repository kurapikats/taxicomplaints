<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\TaxiComplaint;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        if (!Auth::user()->isAdmin())
        {
            Auth::logout();
        }
    }

    public function dashboard()
    {
        $invalid_taxi_complaints = TaxiComplaint::where('valid', '=', 0)
            ->orderBy('id', 'desc')->paginate(10);
        $valid_taxi_complaints = TaxiComplaint::where('valid', '=', 1)
            ->orderBy('id', 'desc')->paginate(10);

        $taxi_complaints['unvalidated'] = $invalid_taxi_complaints;
        $taxi_complaints['validated'] = $valid_taxi_complaints;

        return view('admin.dashboard', compact('taxi_complaints'));
    }
}
