<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Mail;

/**
 * Taxi Complaints
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class TaxiComplaint extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['taxi_complaint_id', 'violation_id'];

    /**
     * Get Taxi Details
     *
     * @return object Taxi Details
     */
    public function taxi()
    {
        return $this->belongsTo('App\Taxi')->first();
    }

    /**
     * Get Taxi Violations
     *
     * @return object Taxi Violations
     */
    public function taxi_violations()
    {
        return $this->hasMany('App\TaxiViolation')->get();
    }

    /**
     * Get list of Violations that can be used on dropdowns, listing, etc.
     *
     * @return array List of Violations
     */
    public function violations()
    {
        $violations = [];
        $taxi_violations = $this->taxi_violations();
        foreach ($taxi_violations as $v) {
            $violations[] = $v->violation();
        }
        return $violations;
    }

    /**
     * Get all Taxi Photos
     *
     * @return object Taxi Photos
     */
    public function pictures()
    {
        return $this->taxi()->taxi_pictures();
    }

    /**
     * Get the associated User Details to a Taxi Complaint
     *
     * @return object Associcated User
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by')->first();
    }

    /**
     * Send email to LTFRB support, cc to reporter, bcc to admin
     *
     * @param object $taxi_complaint TaxiComplaint report
     *
     * @return boolean true on success false on failure
     */
    public static function sendMail(TaxiComplaint $taxi_complaint)
    {
        $taxi       = $taxi_complaint->taxi();
        $reporter   = $taxi_complaint->user();
        $violations = $taxi_complaint->violations();

        $data = [
            'taxi'       => $taxi,
            'reporter'   => $reporter,
            'violations' => $violations,
            'complaint'  => $taxi_complaint
        ];

        $target_email   = config('app.taxi_complaint_gov_email');
        $target_name    = config('app.taxi_complaint_gov_name');
        $tc_admin_email = config('app.taxi_complaint_admin_email');
        $tc_admin_name  = config('app.taxi_complaint_app_name');

        $message_data = [
            'reporter'       => $reporter,
            'target_email'   => $target_email,
            'target_name'    => $target_name,
            'tc_admin_email' => $tc_admin_email,
            'tc_admin_name'  => $tc_admin_name,
            'plate_number'   => $taxi->plate_number
        ];

        // send url for full details of the complaints
        $mail = Mail::later(5, 'emails.taxi-complaint', ['data' => $data],
            function($message) use ($message_data) {
                $message->to($message_data['target_email'],
                    $message_data['target_name'])
                ->from($message_data['reporter']->email,
                    $message_data['reporter']->name)
                ->cc($message_data['reporter']->email,
                    $message_data['reporter']->name)
                ->bcc($message_data['tc_admin_email'],
                    $message_data['tc_admin_name'])
                ->replyTo($message_data['reporter']->email,
                    $message_data['reporter']->name)
                ->subject('Taxi Complaint - Plate # : ' .
                    $message_data['plate_number']);
        });

        return $mail;
    }

    /**
     * Get Paginated List of Taxi Complaints
     *
     * @param integer $valid 0 for un-validated (default), 1 for validated reports
     * @param integer $per_page Total number of Reports to fetch per page
     */
    public static function getPaginated($valid = 0, $per_page = 10,
        $order_by = 'id', $sort = 'desc')
    {
        $data = self::where('valid', '=', $valid)
            ->orderBy($order_by, $sort)->paginate($per_page);

        return $data;
    }
}
