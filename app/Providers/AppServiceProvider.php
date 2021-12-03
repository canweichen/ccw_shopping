<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(ENV('APP_ENV') == 'local'){//allow dev enviranment print sql log
            //listen mysql select & print log
            DB::listen(function ($query) {
                foreach($query->bindings as $i => $binding) {
                    if($binding instanceof \DateTime) {
                        $query->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    }else{
                        if(is_string($binding)) {
                            $query->bindings[$i] = "'$binding'";
                        }
                    }
                }
                // Insert bindings into query
                $time = $query->time;
                $sql = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);
                $query = vsprintf($sql, $query->bindings).' '."[time:{$time} ms]";
                Log::notice($query);
            });
        }
    }
}
