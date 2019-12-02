<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    
    protected $fillable = [
        'tournament_id', 'vysledky', 'uroven_pavouka'
    ];

    public function tournament(){
        return $this->belongsTo('App\Tournament');
    }

    public function ucastnici_user(){
        return $this->belongsToMany('App\User')->withPivot('vyhra');
    }

    public function ucastnici_team(){
        return $this->belongsToMany('App\Team')->withPivot('vyhra');
    }

    public function statistics(){
        return $this->hasMany('App\Statistic');
    }

}
