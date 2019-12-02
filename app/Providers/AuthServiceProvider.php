<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('logged', function($user){
            return (!empty($user->name));
        });

        Gate::define('edit-post', function($user, $post){
            return ($user->id == $post->user->id || $user->administrator == true );
        });

        Gate::define('edit-user', function($user, $post){
            return ($user->id == $post->id || $user->administrator == true );
        });

        Gate::define('edit-tournament', function($user, $post){   
            return ($user->id == $post->user->id || $user->administrator == true );
        });
        Gate::define('enter-tournament', function($user, $post){   
            foreach($user->je_v_teamu as $team ){
                if($team->tournaments->where('id', $post->id)->count() > 0){
                    return false;
                }
            }
            /*if($user->tournaments->where('id', $post->id)->count() > 0){
                return false;
            }*/
            if($user->registered_tournaments->where('id', $post->id)->count() > 0){
                return false;
            }
            return true;
        });
        Gate::define('enter-tournament-judge', function($user, $post){   
            foreach($user->je_v_teamu as $team ){
                if($team->tournaments->where('id', $post->id)->count() > 0){
                    return false;
                }
            }
            /*if($user->tournaments->where('id', $post->id)->count() > 0){
                return false;
            }*/
            if($user->registered_tournaments->where('id', $post->id)->count() > 0){
                return false;
            }

            if($post->registered_users()->wherePivot('rozhodci', '1')->count() > 0 ){
                return false;
            }

            return true;
        });
        Gate::define('leave-tournament', function($user, $post){   
            /*if($user->tournaments->where('id', $post->id)->count() > 0){
                return false;
            }*/
            if($user->registered_tournaments->where('id', $post->id)->count() > 0){
                return true;
            }
            return false;
        });
        Gate::define('enter-tournament-team', function($user, $post, $team){  
            foreach($team->clenove as $user){
                foreach($user->je_v_teamu as $team ){
                    if($team->tournaments->where('id', $post->id)->count() > 0){
                        return false;
                    }
                }
            } 

            return true;
        });
        Gate::define('deregister-team', function($user, $post, $team){  
            if($user->id == $post->user->id || $user->id == $team->user->id || $user->administrator == 1){
                return true;
            }
        });
        Gate::define('deregister-jineho-ucastnika', function($user, $post){  
            if($user->id == $post->user->id || $user->administrator == 1){
                return true;
            }
        });




        Gate::define('edit-sponsor', function($user){         
            if($user->tournaments()->count() > 0 || $user->administrator == 1 ){
                return true;
            }
        });

        Gate::define('edit-match', function($user, $tournament){   
            if($user->id == $tournament->user->id || $user->administrator == 1  
                || $tournament->registered_users()->withPivot('rozhodci', '=', '1' )->where('id', $user->id)->count() > 0){
                return true;
            }
        });



        Gate::define('edit-team', function($user, $team){   
            if($user->id == $team->user->id || $user->administrator == 1 ){
                return true;
            }
        });
        Gate::define('enter-team', function($user, $team){  
            if((!$team->clenove->contains('id', $user->id)) && ($team->user->id != $user->id) ){
                return true;
            }
        });
        Gate::define('leave-team', function($user, $team){   
            if(($team->clenove->contains('id', $user->id)) && ($team->user->id != $user->id) ){
                return true;
            }
        });

        Gate::define('create-statistic', function($user, $match){   
            if( in_array($user->id, $match->tournament->registered_users()->wherePivot('rozhodci', '=', '1' )->pluck('id')->toArray() ) || $user->administrator == 1 ){
                return true;
            }
        });



        //Auth::user()->registered_tournaments()->wherePivot('rozhodci', '1')->count()
    }
}
