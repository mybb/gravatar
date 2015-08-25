<?php
/**
 * Gravatar Service provider for Laravel 5
 *
 * @author    MyBB Group
 * @version   2.0.0
 * @package   mybb/gravatar
 * @copyright Copyright (c) 2015, MyBB Group
 * @license   http://www.mybb.com/licenses/bsd3 BSD-3
 * @link      http://www.mybb.com
 */

namespace MyBB\Gravatar\Providers;

use Illuminate\Support\ServiceProvider;
use MyBB\Gravatar\Generator;

class GravatarServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var boolean
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../../resources/config/gravatar.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('gravatar.php');
        } else {
            $publishPath = base_path('config/gravatar.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gravatar', function ($app) {
            return new Generator(config('gravatar'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['gravatar'];
    }
}
