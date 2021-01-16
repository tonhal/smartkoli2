<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
