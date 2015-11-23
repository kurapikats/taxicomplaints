<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\TaxiComplaint;
use App\User;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        if (Auth::user() && !Auth::user()->isAdmin())
        {
            Auth::logout();
        }
    }

    public function dashboard()
    {
        $invalid_taxi_complaints = TaxiComplaint::getPaginated(0);
        $valid_taxi_complaints = TaxiComplaint::getPaginated(1);

        $taxi_complaints['unvalidated'] = $invalid_taxi_complaints;
        $taxi_complaints['validated'] = $valid_taxi_complaints;

        return view('admin.dashboard', compact('taxi_complaints'));
    }

    public function users()
    {
        $users = User::getPaginated();

        return view('admin.users', compact('users'));
    }

    public function deleteUser(Request $request)
    {
        $user = User::deleteUser($request->user_id);

        return redirect('/admin/users')->with('message',
            'User : ' . $user->name . ' has been deleted.');
    }
}
