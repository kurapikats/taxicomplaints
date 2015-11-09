<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Taxi extends Model
{
    protected $fillable = ['plate_number', 'name', 'description'];

    public function taxi_pictures()
    {
        // todo: this can be empty, don't add get?
        return $this->hasMany('App\TaxiPicture')->get();
    }

    public function taxi_complaints()
    {
        return $this->hasMany('App\TaxiComplaint')->get();
    }

    public function taxi_violations()
    {
        return $this->hasManyThrough('App\TaxiViolation',
            'App\TaxiComplaint')->get();
    }

    // this is used by the api for friendly values
    public function violations()
    {
        $taxi_complaints = $this->taxi_complaints();
        foreach ($taxi_complaints as $k => $taxi_complaint)
        {
            if (!empty($taxi_complaint->violations()))
            {
                //$taxi_complaint->id <- index it?
                $violations[$taxi_complaint->id] = $taxi_complaint->violations();
            }
        }

        return $violations;
    }

    // return only unique violations
    public function uniqViolations()
    {
        $violations = [];

        foreach ($this->violations() as $violation)
        {
            $c = 0;
            foreach ($violation as $v)
            {
                $violations[$v->id] = $v->name;
                $c++;
            }
        }

        $uniq_violations = array_unique($violations);

        return $uniq_violations;
    }

    public static function search($keyword, $field_name = 'plate_number',
        $order_by = 'asc', $limit = 10)
    {
        $keyword = self::sanitize($keyword);
        $taxis   = Taxi::where($field_name, 'like', '%'.$keyword.'%')
                    ->limit($limit)
                    ->orderBy($field_name, $order_by)->get();

        return $taxis;
    }

    public static function sanitize($keyword)
    {
        return strtoupper(str_replace(['_', '-', ' '], '', $keyword));
    }

    public static function store($request, $user)
    {
        $data = DB::transaction(function() use ($request, $user)
        {
            // register the new user
            if (is_null($user))
            {
                $user = new User();
                $user->name = $request->full_name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->contact_number = $request->contact_number;
                $user->save();
            }

            $user_id      = ($user)?$user->id:1; // user's id or admin
            $plate_number = Taxi::sanitize($request->plate_number);

            // find if it exist, if not create one
            // if result yielded more than 1 do a taxi search
            $taxi_search = Taxi::search($plate_number);
            if (count($taxi_search) === 1)
            {
                // use the existing taxi,
                // todo: should we also update with the new data?
                $taxi = $taxi_search->first();
            }
            else if (count($taxi_search) === 0)
            {
                // create new taxi record
                $taxi = new Taxi();
                $taxi->plate_number = $plate_number;
                $taxi->name         = $request->name;
                $taxi->description  = $request->description;
                $taxi->save();
            }
            else
            {
                return ['plate_number' => $plate_number];
            }

            if (!empty($request->incident_time))
            {
                $incident_time = date('H:i:s', strtotime($request->incident_time));
            }
            else
            {
                $incident_time = null;
            }

            $taxi_complaint                     = new TaxiComplaint();
            $taxi_complaint->taxi_id            = $taxi->id;
            $taxi_complaint->incident_date      = $request->incident_date;
            $taxi_complaint->incident_time      = $incident_time;
            $taxi_complaint->incident_location  = $request->incident_location;
            $taxi_complaint->notes              = $request->notes;
            $taxi_complaint->drivers_name       = $request->drivers_name;
            $taxi_complaint->created_by         = $user_id;
            $taxi_complaint->save();

            foreach ($request->violations as $violation_id)
            {
                $taxi_violation                    = new TaxiViolation();
                $taxi_violation->taxi_complaint_id = $taxi_complaint->id;
                $taxi_violation->violation_id      = $violation_id;
                $taxi_violation->save();
            }

            $path_prefix = 'images/uploads/' . $user_id;
            // this is the directory where to save the uploaded images
            $user_dir = public_path($path_prefix);

            if (!empty($request->taxi_pictures) &&
                is_array($request->taxi_pictures))
            {
                foreach ($request->taxi_pictures as $picture)
                {
                    if (!is_null($picture) && $picture->isValid())
                    {
                        //prepare the filename and url
                        $fname     = str_random(40);
                        $ext       = strtolower($picture
                                        ->getClientOriginalExtension());
                        $filename  = $fname . '.' . $ext;
                        $file_uri  = $path_prefix . '/' . $filename;

                        // move the uploaded file to it's location
                        $picture->move($user_dir, $filename);

                        // save the url and new filename to db
                        $taxi_picture = new TaxiPicture();
                        $taxi_picture->taxi_id           = $taxi->id;
                        // added taxi_complaint_id so that we could
                        // track taxi physical changes
                        $taxi_picture->taxi_complaint_id = $taxi_complaint->id;
                        $taxi_picture->path              = $file_uri;
                        $taxi_picture->created_by        = $user_id;
                        $taxi_picture->save();
                    }
                }
            }

            // $this->setTaxiId($taxi->id);
            return ['taxi_id' => $taxi->id];
        }); // end db::transaction

        return $data;
    }
}
