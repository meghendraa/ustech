<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Match;
use App\Http\Requests\saveWinner;
use App\Http\Requests\saveFinalWinner;
use App\Point;

class MatchController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * createMatch
     */
    public function createMatch() {

        // get random teams
        $arrTeam = Team::getRandomData();

        foreach ($arrTeam as $varTeam) {
            $arrMatchSchedule = [];
            $arrMatchSchedule['team_1'] = $varTeam[0]['id'];
            $arrMatchSchedule['team_2'] = $varTeam[1]['id'];
            Match::insert($arrMatchSchedule);
        }

        return redirect()->route('show_match');
    }

    /**
     * showMatch
     */
    public function showMatch() {

        // get all matches
        $arrMatch = Match::getAllMatch();

        // round 2 (final) match
        $arrFinalMatch = Match::getFinalMatch();

        // get points
        $arrPoints = Point::getAllPoints();
        //dd($arrPoints);

        return view('match.show')
                        ->with('arrMatch', $arrMatch)
                        ->with('arrFinalMatch', $arrFinalMatch)
                        ->with('arrPoints', $arrPoints);
    }

    /**
     * saveMatchWinner
     * @param saveWinner $request
     */
    public function saveMatchWinner(saveWinner $request) {

        $winnerTeam1 = $request->match_winner_0;
        $winnerTeam2 = $request->match_winner_1;

        // update win team data in database
        $arrMatch1 = [];
        $arrMatch1['winner'] = $winnerTeam1;
        // Match::where('team_1', $winnerTeam1)->orwhere('team_2', $winnerTeam1)->update($arrMatch1);
        $match1 = Match::where('team_1', $winnerTeam1)->orwhere('team_2', $winnerTeam1)->first();
        $match1->update($arrMatch1);
        $this->savePoints($match1->id, $winnerTeam1); // save points

        $arrMatch2 = [];
        $arrMatch2['winner'] = $winnerTeam2;
        // Match::where('team_1', $winnerTeam2)->orwhere('team_2', $winnerTeam2)->update($arrMatch2);
        $match2 = Match::where('team_1', $winnerTeam2)->orwhere('team_2', $winnerTeam2)->first();
        $match2->update($arrMatch2);
        $this->savePoints($match2->id, $winnerTeam2); // save points

        /**
         * save winner data for next match
         */
        $arrWinner = [];
        $arrWinner['team_1'] = $winnerTeam1;
        $arrWinner['team_2'] = $winnerTeam2;
        Match::insert($arrWinner);

        return redirect()->route('show_match');
    }

    /**
     * saveFinalWinner
     * @param saveFinalWinner $request
     */
    public static function saveFinalMatchWinner(saveFinalWinner $request) {

        $match_id = $request->match_id;
        $winnerTeam = $request->final_match_winner;

        $arrMatch = [];
        $arrMatch['winner'] = $winnerTeam;
        Match::where('id', $match_id)->update($arrMatch);

        self::savePoints($match_id, $winnerTeam); // save points

        return redirect()->route('show_match');
    }

    /**
     * savePoints
     * @param type $match_id
     * @param type $team_id
     */
    public static function savePoints($match_id, $team_id) {
        // save points for winning team
        $arrPoints = [];
        $arrPoints['match_id'] = $match_id;
        $arrPoints['winning_team'] = $team_id;
        $arrPoints['points'] = 10;
        Point::insert($arrPoints);
    }

}
