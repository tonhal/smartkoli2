<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LaundryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        $laundries = DB::table('laundries')
            ->join('users', 'laundries.user_id', '=', 'users.id')
            ->select('laundries.id','users.name as title','laundries.start','laundries.end')
            ->get()
            ->toJson();

        return $laundries;

    }
}
