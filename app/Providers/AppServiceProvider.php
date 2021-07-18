<?php

namespace App\Providers;

use App\Models\Category;
use Facade\FlareClient\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('categories')) {
            $categories = Category::select(['name', 'slug'])->where('category_id', null)->get();
            //adding data to all views
            view()->share('categories', $categories);
        }


        Paginator::useBootstrap();
    }
}