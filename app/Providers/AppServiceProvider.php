<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::share('scriptsDatatables',[
            'plugins/datatables/jquery.dataTables.min.js',
            "plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
            "plugins/datatables-responsive/js/dataTables.responsive.min.js",
            "plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
            "plugins/datatables-buttons/js/dataTables.buttons.min.js",
            "plugins/datatables-buttons/js/buttons.bootstrap4.min.js"
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
