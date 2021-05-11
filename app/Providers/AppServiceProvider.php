<?php

namespace App\Providers;

use App\Defines\Language;
use App\Models\Book;
use App\Models\Reader;
use App\Observers\BookObserver;
use App\Observers\ReaderObserver;
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

        View::share('_LANGUAGES',Language::get());

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Reader::observe(ReaderObserver::class);
        Book::observe(BookObserver::class);
    }
}
