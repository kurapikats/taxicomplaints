<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;
use App\Taxi;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'contact_number',
        'address', 'photo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo('App\Role')->first();
    }

    public function taxi_complaints()
    {
        return $this->hasMany('App\TaxiComplaint', 'created_by', 'id')->paginate(10);
    }

    public function taxis()
    {
        $taxis = [];
        $taxi_complaints = TaxiComplaint::where('created_by', $this->id)->get();

        foreach ($taxi_complaints as $tc)
        {
            $taxis[] = $tc->taxi()->toArray();
        }
        $taxis = $this->unique_multidim_array($taxis, 'id');

        return $taxis;
    }

    public function unique_multidim_array($array, $key) {
        $i          = 0;
        $temp_array = array();
        $key_array  = array();

        foreach ($array as $val)
        {
            if (!in_array($val[$key], $key_array))
            {
                $key_array[$i]  = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }

        return $temp_array;
    }

    public function isAdmin()
    {
        if (Auth::user()->role()->name === 'Admin')
        {
            return true;
        }

        return false;
    }

    public static function deleteUser($user_id)
    {
        $user = self::find($user_id);
        $user->delete();

        return $user;
    }

    public static function getPaginated($per_page = 10, $order_by = 'id',
        $sort = 'asc')
    {
        $data = self::orderBy($order_by, $sort)->paginate($per_page);

        return $data;
    }
}
