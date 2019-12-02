<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'jmeno', 'administrator', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];







    public function vlastni_team(){
        
        return $this->hasMany('App\Team'); 
    }



    public function je_v_teamu(){
        return $this->belongsToMany('App\Team');
    }

    public function statistics(){
        
        return $this->hasMany('App\Statistic'); 
    }

    public function tournaments(){
        
        return $this->hasMany('App\Tournament'); 
    }
    
    public function registered_matches(){
        return $this->belongsToMany('App\Match')->withPivot('vyhra');
    }

    public function registered_tournaments(){
        return $this->belongsToMany('App\Tournament')->withPivot('rozhodci', 'poplatek_uhrazen');
    }




}
