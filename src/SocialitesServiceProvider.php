<?php

namespace Atomjoy\Socialites;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class SocialitesServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'socialites');
	}

	public function boot(Kernel $kernel)
	{
		$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'socialites');

		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../config/config.php' => config_path('socialites.php'),
			], 'socialites-config');

			$this->publishes([
				__DIR__ . '/../resources/views' => resource_path('views/vendor/socialites')
			], 'socialites-views');

			$this->publishes([
				__DIR__ . '/../storage/app/public' => public_path('vendor/socialites')
			], 'socialites-assets');
		}
	}
}
