<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DB;

class Guest extends Model
{
    /**
     * Hides timestamp fields from guests query results
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user of this guest
     */
    public function user() {

        return $this->belongsTo('App\User');

    }

    /**
     * Check whether the guestroom is occupied for a timeinterval
     */
    public function isGuestroomOccupied() {

        //$end_date = date_create($this->departure)->modify('-1 days')->format('Y-m-d');

        //dd($end_date);
        //dd($this->arrival);

        $overlap = DB::table('guests')
                ->select('id')
                ->where('guestroom', 1)
                ->where('arrival', '<', $this->departure)
                ->where('departure', '>', $this->arrival)
                ->exists();

        return $overlap;

    }
}
