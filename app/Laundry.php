<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Laundry extends Model
{
    /**
     * Get the user of this laundry
     */
    public function user() {

        $this->belongsTo('User');

    }
}
