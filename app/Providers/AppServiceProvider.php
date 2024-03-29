<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		// Services
		$this->app->bind(\App\Http\Interfaces\Services\AuthServiceInterface::class, \App\Http\Services\AuthService::class);
		$this->app->bind(\App\Http\Interfaces\Services\TaskServiceInterface::class, \App\Http\Services\TaskService::class);
		// Repositories
		$this->app->bind(\App\Http\Interfaces\Repositories\UserRepositoryInterface::class, \App\Http\Repositories\UserRepository::class);
		$this->app->bind(\App\Http\Interfaces\Repositories\SystemLogRepositoryInterface::class, \App\Http\Repositories\SystemLogRepository::class);
		$this->app->bind(\App\Http\Interfaces\Repositories\TaskRepositoryInterface::class, \App\Http\Repositories\TaskRepository::class);
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		//
	}
}
