<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Taxi;

/**
 * Taxi Controller
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class TaxiController extends Controller
{
    private $data;

    public function __construct()
    {
      $this->data = Taxi::getCommonPageData();
    }

    /**
     * Get: Home Page
     *
     * @return mixed View Home Page
     */
    public function home()
    {
        return view('layouts.master', $this->data);
    }

    /**
     * Display's the selected Taxi Details
     *
     * @param  int  $taxi_id
     *
     * @return mixed Taxi Details Info
     */
    public function show($taxi_id)
    {
        $taxi = Taxi::find($taxi_id);

        if (is_null($taxi))
        {
            return redirect('/')->with('message', 'Taxi not found');
        }

        return view('taxi.home', compact('taxi') + $this->data);
    }

}
