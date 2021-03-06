<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * Taxi Operations
 *
 * @author Jesus B. Nana <jesus.nana@gmail.com>
 * @copyright 2015
 * @license /LICENSE MIT
 */
class Taxi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plate_number', 'name', 'description'];

    /**
     * Get all pictures associated to this taxi instance
     *
     * @return object List of Pictures associated to a Taxi
     */
    public function taxi_pictures()
    {
        // todo: this can be empty, don't add get?
        return $this->hasMany('App\TaxiPicture')->get();
    }

    /**
     * Get all Taxi Complains associated to this taxi instance
     *
     * @return object List of Taxi Complaints
     */
    public function taxi_complaints()
    {
        return $this->hasMany('App\TaxiComplaint')->get();
    }

    /**
     * Get all Taxi Violations associated to this taxi instance
     *
     * @return object Taxi Violations associated with Taxi
     */
    public function taxi_violations()
    {
        return $this->hasManyThrough('App\TaxiViolation',
            'App\TaxiComplaint')->get();
    }

    /**
     * This is used by the API endpoint for friendly values
     * Get the list of associated Violations of a Taxi
     *
     * @return array List of Violations
     */
    public function violations()
    {
        $taxi_complaints = $this->taxi_complaints();
        $violations      = [];

        foreach ($taxi_complaints as $k => $taxi_complaint)
        {
            // Add to array only if not empty
            if (!empty($taxi_complaint->violations()))
            {
                // Group violations by taxi_complaint.id
                $violations[$taxi_complaint->id] = $taxi_complaint->violations();
            }
        }

        return $violations;
    }

    /**
     * Filter out duplicates and return only unique violations
     *
     * @return array Unique Violations
     */
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

    /**
     * Search Taxi database by plate number or taxi name
     *
     * @param string $keyword The text to search
     * @param string $order_by Sort order can be 'asc' ascending or
     *        'desc' descending
     * @param int $limit Limit the number of search results
     *
     * @return object List of matched Taxi
     */
    public static function search($keyword, $order_by = 'asc', $limit = 10)
    {
        $keyword = self::sanitize($keyword);
        $taxis   = self::where('plate_number', 'like', '%'.$keyword.'%')
                    ->orWhere('name', 'like', '%'.$keyword.'%')->limit($limit)
                    ->orderBy('plate_number', $order_by)->get();

        return $taxis;
    }

    /**
     * Sanitize's text input from user, remove _, -, white spaces and
     * this also converts the text uppercase letters
     *
     * @param string $keyword The text to sanitize
     *
     * @return string Sanitized text
     */
    public static function sanitize($keyword)
    {
        return strtoupper(str_replace(['_', '-', ' '], '', $keyword));
    }

    /**
     * Store Taxi and Report information to the database
     * If $user param is null, this will register the based on the form info.
     * If the reported taxi already exist on the database use it then create a report
     * If it doesn't exist yet, register this a new taxi then create a report
     *
     * @param object $request Request object from the form
     * @param object $user User object
     *
     * @return array Taxi information
     */
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
            $plate_number = self::sanitize($request->plate_number);

            // 1. find if it exist, if not create one
            // 2. if search result yielded more than 1 do a taxi search
            $taxi_search = self::search($plate_number);

            // use the existing taxi,
            if (count($taxi_search) === 1)
            {
                // todo: should we also update with the new data?
                $taxi = $taxi_search->first();
                $taxi->description = $request->description;
                $taxi->save();
            }
            // no search result, create new taxi record
            else if (count($taxi_search) === 0)
            {
                $taxi = new Taxi();
                $taxi->plate_number = $plate_number;
                $taxi->name         = $request->name;
                $taxi->description  = $request->description;
                $taxi->save();
            }
            // search result more than 1, use plate_number as search parameter
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

            return ['taxi_id' => $taxi->id];
        }); // end db::transaction

        return $data;
    }

    /**
     * Get paginated taxi data
     *
     * @param $per_page int Number of Taxi to list, defaults to 10
     * @param $order_by string What DB field used to sort the list, defaults to 'id'
     *
     * @return object Taxi list that can be iterated
     */
    public static function getPaginated($per_page = 10, $order_by = 'id',
        $sort = 'desc')
    {
        $data = self::orderBy($order_by, $sort)->paginate($per_page);

        return $data;
    }

    /**
     * Get common page data like Top Violators, Recently Added, List of Violations
     *
     * @return array Data for Top Violators, Recently Added, List of Violations
     */
    public static function getCommonPageData()
    {
        $top_violators = TaxiViolation::getTopViolators(10);
        $taxis = self::getPaginated();

        // This is used by Report Form for list of Violations
        $violations = Violation::lists('name', 'id');

        $data = compact('taxis', 'top_violators', 'violations');

        return $data;
    }
}
