<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Mail;

class TaxiComplaint extends Model
{
    public function taxi()
    {
        return $this->belongsTo('App\Taxi')->first();
    }

    public function taxi_violations()
    {
        return $this->hasMany('App\TaxiViolation')->get();
    }

    public function violations()
    {
        $violations = [];
        $taxi_violations = $this->taxi_violations();
        foreach ($taxi_violations as $v) {
            $violations[] = $v->violation();
        }
        return $violations;
    }

    public function pictures()
    {
        return $this->taxi()->taxi_pictures();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by')->first();
    }

    /**
     *
     *
     */
    public function isValid()
    {
        $data = 'False';

        if ($this->valid == 1)
        {
            $data = 'True';
        }

        return $data;
    }

    public function mailSent()
    {
        $data = 'False';

        if ($data == 1)
        {
            $data = 'True';
        }

        return $data;
    }

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
}
