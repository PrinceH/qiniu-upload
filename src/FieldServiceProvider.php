<?php

namespace Princeh\QiniuUpload;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('qiniu-upload', __DIR__.'/../dist/js/field.js');
            Nova::style('qiniu-upload', __DIR__.'/../dist/css/field.css');
        });
        $this->registerRoutes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    protected function routeConfiguration()
    {
        return [
            'namespace' => 'Princeh\QiniuUpload',
            'prefix'    => 'qiniu/upload',
        ];
    }
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/route.php');
        });
    }
}
