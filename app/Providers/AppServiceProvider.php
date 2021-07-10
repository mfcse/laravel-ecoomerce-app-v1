<?php

namespace App\Providers;

use App\Models\Category;
use Facade\FlareClient\View;
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
        $categories = Category::select(['name', 'slug'])->where('category_id', null)->get();
        //adding data to all views
        view()->share('categories', $categories);
    }
}