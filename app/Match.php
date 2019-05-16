<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model {

    protected $table = 'matches';

    /**
     * Custom primary key is set for the table
     * 
     * @var integer
     */
    protected $primaryKey = 'id';

    /**
     * Maintain created_at and updated_at automatically
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * getAllMatch
     */
    public static function getAllMatch() {
        $arrData = Self::select('t1.name as team_1_name', 't2.name as team_2_name', 't1.id as team_1_id', 't2.id as team_2_id', 't3.name as team_win_name')
                ->leftjoin('teams as t1', 't1.id', '=', 'matches.team_1')
                ->leftjoin('teams as t2', 't2.id', '=', 'matches.team_2')
                ->leftjoin('teams as t3', 't3.id', '=', 'matches.winner')
                ->skip(0)->take(2)
                ->get();
        // dd($arrData);
        return $arrData;
    }

    /**
     * getFinalMatch
     */
    public static function getFinalMatch() {
        $arrData = Self::select('matches.id as match_id', 't1.name as team_1_name', 't2.name as team_2_name', 't1.id as team_1_id', 't2.id as team_2_id', 't3.name as team_win_name')
                ->leftjoin('teams as t1', 't1.id', '=', 'matches.team_1')
                ->leftjoin('teams as t2', 't2.id', '=', 'matches.team_2')
                ->leftjoin('teams as t3', 't3.id', '=', 'matches.winner')
                ->skip(2)->take(1)
                ->get();
        // dd($arrData);
        return $arrData;
    }

}
