<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Team extends Model {

    protected $table = 'teams';

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

    public static function getRandomData() {
        $arrRandTeam = SELF::select('*')->orderBy(DB::raw('RAND()'))->get()->toArray();
        $arrTeam = array_chunk($arrRandTeam, 2);
        return $arrTeam;
    }

}
