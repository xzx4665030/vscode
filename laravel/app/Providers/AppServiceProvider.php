<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        //与所有视图共享数据
        View::share([
            'code' => '200',
            'msg' => '成功',
            'data' => [
                'name' => 'linfeng',
                'age' => '24',
            ],
        ]);

        Relation::morphMap([
            '1' => 'App\Member',
            '2' => 'App\Card',
        ]);
    }
}
