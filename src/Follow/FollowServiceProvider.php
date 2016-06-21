<?php namespace Fela\Follow;


use Illuminate\Support\ServiceProvider;

class FollowServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */

    public function register(){}

    public function boot()
    {
        // Publish config & migration files
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('follow.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations/2016_05_28_214920_create_followers_table.php' => database_path('migrations/2016_05_28_214920_create_followers_table.php'),
        ], 'migrations');
    }


}