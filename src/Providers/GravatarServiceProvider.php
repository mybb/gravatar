<?php
/**
 * Gravatar Service provider for Laravel 5.0.
 *
 * @author    MyBB Group
 * @version   2.0.0
 * @package   mybb/gravatar
 * @copyright Copyright (c) 2015, MyBB Group
 * @license   http://www.mybb.com/licenses/bsd3 BSD-3
 * @link      http://www.mybb.com
 */

namespace MyBB\Gravatar\Providers;

use Illuminate\Contracts\Config\Repository;
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
	 * @param Repository $config
	 *
	 * @return void
	 */
	public function boot(Repository $config)
	{
		$this->app->bind(
			'gravatar',
			function () use ($config) {
				return new Generator($config->get('gravatar'));
			}
		);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['config']->package('mybb/gravatar', __DIR__ . '/../resources/config/');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'gravatar'
		];
	}
}
