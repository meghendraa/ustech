<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Player;

class TeamController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        // get all teams data here
        $arrData = Team::all();

        return view('team.index')->with('arrData', $arrData);
    }

    /**
     * viewDetails
     */
    public function viewDetails($id) {

        // get team data
        $arrTeamData = Team::where('id', $id)->first();

        // get team player details
        $arrPlayers = Player::where('team_id', $id)->get();

        return view('team.details')
                        ->with('arrTeamData', $arrTeamData)
                        ->with('arrPlayers', $arrPlayers);
    }

}
