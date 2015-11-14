<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class UserController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    public function profile()
    {
        $user = $this->user;
        return view('user.profile', compact('user'));
    }

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
