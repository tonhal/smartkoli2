<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guest;
use DateTime;

class GuestController extends Controller
{
    public function __construct() {

        $this->middleware('auth');

    }

    public function index() {

        $guests = Guest::with('user')->get()->toJson(JSON_PRETTY_PRINT);

        return $guests;
    }

    public function store(Request $request) {

        $this->validate($request, [
            'arrival' => 'required|date_format:Y-m-d',
            'departure' => 'required|date_format:Y-m-d',
            'capita' => 'required|numeric|between:1,10',
            'guestroom' => 'required|boolean',
            'comment' => 'required',
        ]);

        $guest = new Guest();
        $guest->arrival = $request->arrival;
        $guest->departure = $request->departure;
        $guest->capita = $request->capita;
        $guest->guestroom = $request->guestroom;
        $guest->comment = $request->comment;

        if(!(new DateTime($guest->arrival) < new DateTime($guest->departure))) {
            return response()->json([
                'status' => 'error',
                'msg' => 'A távozásnak későbbi időpontra kell esnie, mint az érkezésnek.'
            ], 422);
        }

        if($guest->guestroom) {
            if($guest->isGuestroomOccupied()) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Ennek az időszaknak valamelyik részére már foglalt a vendégszoba.'
                ], 422);
            }
        }
        
        auth()->user()->guests()->save($guest);

        return response()->json([
            'id' => $guest->id,
            'title' => auth()->user()->name,
            'start' => $guest->arrival,
            'end' => $guest->departure,
            'userId' => auth()->id(),
            'guestroom' => $guest->guestroom,
            'color' => $guest->guestroom == 1 ? "#38c172" : null,
        ]);
    }
}
