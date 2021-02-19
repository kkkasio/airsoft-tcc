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

        Gate::define('manage-event', function ($user, $event) {
            if ($user->type === 'Liga') {
                $league = $user->league;

                return $event->league->id === $league->id ?  true : false;
            } else {
                $profile = $user->profile;

                if ($event->team && $profile->team && $profile->team->team_id === $event->team->id && $profile->team->type === 'Moderador')
                    return true;
                return false;
            }
        });


        Gate::define('can-comment', function ($user, $event) {
            if ($user->type === 'Membro') {
                $profile  = $user->profile;

                return $event->subscribers->firstWhere('profile_id', $profile->id) && !$event->ratings->firstWhere('profile_id', $profile->id);
            }
        });
    }
}
