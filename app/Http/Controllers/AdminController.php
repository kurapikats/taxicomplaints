<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\TaxiComplaint;
use App\User;

/**
 * Admin Controller
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class AdminController extends Controller
{

    /**
     * User must be logged-in and an admin to use these features
     */
    public function __construct()
    {
        $this->middleware('auth');

        if (Auth::user() && !Auth::user()->isAdmin())
        {
            Auth::logout();
        }
    }

    /**
     * Admin Dashboard Page
     *
     * @return mixed View Admin Dashboard Page
     */
    public function dashboard()
    {
        $invalid_taxi_complaints = TaxiComplaint::getPaginated(0);
        $valid_taxi_complaints = TaxiComplaint::getPaginated(1);

        $taxi_complaints['unvalidated'] = $invalid_taxi_complaints;
        $taxi_complaints['validated'] = $valid_taxi_complaints;

        return view('admin.dashboard', compact('taxi_complaints'));
    }

    /**
     * List of Registered Users
     *
     * @return mixed View the List of Registerd Users Page
     */
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
