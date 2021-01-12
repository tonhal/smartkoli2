<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use App\User;
use App\Laundry;

class LaundryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        $laundries = Laundry::with('user')->get()->toJson(JSON_PRETTY_PRINT);

        return $laundries;

    }

    public function store(Request $request) {

        $this->validate($request, [
            'date' => 'required|date_format:Y-m-d',
            'start' => 'required|date_format:H:i:s',
            'end' => 'required|date_format:H:i:s',
        ]);

        $laundry = new Laundry();
        $laundry->start = $request->date . " " . $request->start;
        $laundry->end = $request->date . " " . $request->end;

        if(!(new DateTime($laundry->start) < new DateTime($laundry->end))) {
            return response()->json([
                'status' => 'error',
                'msg' => 'A mosás végének későbbi időpontnak kell lennie, mint a mosás kezdetének.'
            ], 422);
        }

        if($laundry->isOverlapping()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Ennek az idősávnak egy bizonyos részére már foglalt a mosógép.'
            ], 422);
        }

        auth()->user()->laundries()->save($laundry);

        return response()->json([
            'id' => $laundry->id,
            'title' => auth()->user()->name,
            'start' => $laundry->start,
            'end' => $laundry->end,
            'userId' => auth()->id()
        ]);

    }

    public function destroy($id) {

        $laundry = Laundry::find($id); 

        if($laundry->user_id == auth()->id()) {
            Laundry::destroy($id);
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Nincs jogosultságod ennek a mosásnak a törlésére.'
            ], 403);
        }
    }
}
