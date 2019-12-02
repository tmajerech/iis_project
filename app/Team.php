<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    
    protected $fillable = [
        'nazev', 'logo'
    ];

    public function user(){
        
        return $this->belongsTo('App\User');
    }

    public function clenove(){
        return $this->belongsToMany('App\User');
    }

    public function tournaments(){
        return $this->belongsToMany('App\Tournament')->withPivot('poplatek_uhrazen');
    }

    public function matches(){
        return $this->belongsToMany('App\Match')->withPivot('vyhra');
    }


}
