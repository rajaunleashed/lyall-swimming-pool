<?php

namespace App\Providers;

use App\Facades\HelperFacade;
use App\Models\MonthlyStock;
use App\Models\Sale;
use App\Observers\MonthlyStockObserver;
use App\Observers\SaleObserver;
use App\Utilities\Helper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;

class VoyagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('helper',function() {
            return new Helper();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       Voyager::addAction(\App\Actions\PrintAction::class);

    }
}
