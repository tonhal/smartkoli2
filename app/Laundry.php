<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;

class Laundry extends Model
{
    /**
     * Get the user of this laundry
     */
    public function user() {

        $this->belongsTo('User');

    }

    /**
     * Check whether the laundry overlaps with another laundry.
     */
    public function isOverlapping() {

        $overlap = DB::table('laundries')
                ->select('id')
                ->where('start', '<', $this->end)
                ->where('end', '>', $this->start)
                ->exists();

        return $overlap;

    }
}
