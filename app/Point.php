<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Point extends Model {

    protected $table = 'points';

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
     * getAllPoints
     */
    public static function getAllPoints() {
        $arrData = DB::table('teams')
                ->select('teams.name', DB::raw("sum(points.points) as points"))
                ->leftjoin('points', 'points.winning_team', '=', 'teams.id')
                ->groupby('teams.name')
                ->get();
        return $arrData;
    }

}
