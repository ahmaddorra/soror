<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

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
        Response::macro('datatable', function ($draw, $recordsFiltered, $recordsTotal, $data) {
            $json_data = array(
                'draw' => (int)$draw,
                'recordsTotal' => (int)$recordsTotal,
                'recordsFiltered' => (int)$recordsFiltered,
                'data' => $data,
            );
            return json_encode($json_data);
        });
    }
}
