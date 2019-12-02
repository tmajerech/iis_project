<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
 
    protected $fillable = [
        'match_id', 'user_id', 'vojenske_skore', 'ekonomicke_skore', 'technologicke_skore', 'socialni_skore', 'doba_preziti' 
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function match(){
        return $this->belongsTo('App\Match');
    }
}
