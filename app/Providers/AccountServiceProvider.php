<?php namespace Laracasts\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Laracasts\Accounts\Providers\GitHub;

class AccountServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('Laracasts\Accounts\Providers\Contracts\Provider', function($app)
        {
            return new GitHub(
                $app['redirect'],
                new Client,
                getenv('GITHUB_CLIENT_ID'),
                getenv('GITHUB_CLIENT_SECRET')
            );
        });
    }

}
