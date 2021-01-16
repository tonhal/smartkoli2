<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guest;

class GuestController extends Controller
{
    public function __construct() {

        $this->middleware('auth');

    }

    public function index() {

        $guests = Guest::with('user')->get()->toJson(JSON_PRETTY_PRINT);

        return $guests;
    }
}
