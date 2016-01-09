<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

/**
 * User's Controller
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class UserController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    /**
     * Get: View Current User's Profile
     *
     * @return mixed Profile Page
     */
    public function profile()
    {
        $user = $this->user;
        return view('user.profile', compact('user'));
    }

    /**
     * Put: User Profile Update Request
     *
     * @param object $request Data from Edit Profile Form
     *
     * @return mixed Redirects to User's Profile page
     */
    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'photo' => 'image'
        ]);

        $this->user->name = $request->name;
        $this->user->address = $request->address;
        $this->user->contact_number = $request->contact_number;
        $user_id = $this->user->id;

        if ($request->hasFile('photo') && $request->file('photo')->isValid())
        {
            $path_prefix = 'images/uploads/' . $user_id;
            // this is the directory where to save the uploaded images
            $user_dir = public_path($path_prefix);

            $picture = $request->file('photo');

            //prepare the filename and url
            $fname     = str_random(40);
            $ext       = strtolower($picture->getClientOriginalExtension());
            $filename  = $fname . '.' . $ext;
            $file_uri  = $path_prefix . '/' . $filename;

            // move the uploaded file to it's location
            $picture->move($user_dir, $filename);

            // save the url and new filename to db
            $this->user->photo = $file_uri;
        }

        $this->user->save();

        return redirect('/profile');
    }

    /**
     * Put: Change Password Request
     *
     * @param object $request Data from Change Password Form
     *
     * @return mixed Redirects to Profile Page
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        if (Auth::attempt(['email' => $this->user->email,
            'password' => $request->old_password]))
        {
            $this->user->password = bcrypt($request->password);
            $this->user->save();

            return redirect('/profile')->with('status', 'Password has been updated!');
        } else {
            return redirect('/profile')->with('error', 'Current Password is incorrect.');
        }
    }
}
