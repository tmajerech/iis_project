<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    
    protected $fillable = [
        'logo'
    ];


    public function sponsoring(){
        return $this->belongsToMany('App\Tournament')->withPivot('castka');
    }
}
