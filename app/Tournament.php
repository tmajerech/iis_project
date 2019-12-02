<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    
    protected $fillable = [
        'name', 'cena', 'pocet_teamu', 'pocet_hracu', 'typ_hracu', 'poplatek', 'vlastnost_teamu'
    ];
    
    public function user(){        
        return $this->belongsTo('App\User');
    }

    public function matches(){        
        return $this->hasMany('App\Match'); 
    }

    public function sponsors(){        
        return $this->belongsToMany('App\Sponsor')->withPivot('castka'); 
    }

    public function registered_users(){
        return $this->belongsToMany('App\User')->withPivot('rozhodci', 'poplatek_uhrazen');
    }

    public function registered_teams(){
        return $this->belongsToMany('App\Team')->withPivot('poplatek_uhrazen');
    }
}
