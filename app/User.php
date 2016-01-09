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

/**
 * User Account Details
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
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

    /**
     * Get the user's role
     *
     * @return object Role info
     */
    public function role()
    {
        return $this->belongsTo('App\Role')->first();
    }

    /**
     * Get the user's reported Taxi Complaints
     *
     * @return object List of Taxi Complaints
     */
    public function taxi_complaints()
    {
        return $this->hasMany('App\TaxiComplaint', 'created_by', 'id')->paginate(10);
    }

    /**
     * Get the unique reported taxi details
     *
     * @return object List of Taxi's
     */
    public function taxis()
    {
        $taxis = [];
        $taxi_complaints = TaxiComplaint::where('created_by', $this->id)->get();

        foreach ($taxi_complaints as $tc)
        {
            $taxis[] = $tc->taxi()->toArray();
        }
        $taxis = $this->uniqueMultidimArray($taxis, 'id');

        return $taxis;
    }

    /**
     * Remove duplicates on a multidimensional array
     *
     * @param array $array Array that has duplicate data
     * @param string $key Filter using this array key
     *
     * @return array Unique values of the source array
     */
    public function uniqueMultidimArray($array, $key) {
        $i          = 0;
        $unique_array = array();
        $key_array  = array();

        foreach ($array as $val)
        {
            if (!in_array($val[$key], $key_array))
            {
                $key_array[$i]  = $val[$key];
                $unique_array[$i] = $val;
            }
            $i++;
        }

        return $unique_array;
    }

    /**
     * Check if the current user is an Admin role
     *
     * @return boolean true on succcess false on non-admin user
     */
    public function isAdmin()
    {
        if (Auth::user()->role()->name === 'Admin')
        {
            return true;
        }

        return false;
    }

    /**
     * Remove User from the database
     *
     * @param integer $user_id User's ID
     *
     * @return object User info that has been removed
     */
    public static function deleteUser($user_id)
    {
        $user = self::find($user_id);
        $user->delete();

        return $user;
    }

    /**
     * Get Paginated User List
     *
     * @param integer $per_page Number of users per page
     * @param string $order_by DB field which to order, defaults to 'id'
     * @param string $sort Sort direction, defaults to 'asc' ascending,
     *        'desc' for descending
     */
    public static function getPaginated($per_page = 10, $order_by = 'id',
        $sort = 'asc')
    {
        $data = self::orderBy($order_by, $sort)->paginate($per_page);

        return $data;
    }
}
