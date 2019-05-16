<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Match;
use App\Http\Requests\saveWinner;
use App\Http\Requests\saveFinalWinner;
use App\Point;

class PointController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * showPoint
     */
    public function showPoint() {

        // get points
        $arrPoints = Point::getAllPoints();

        return view('point.show')
                        ->with('arrPoints', $arrPoints);
    }

}
