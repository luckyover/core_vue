<?php

namespace App\Repositories;

/**
 * RepositoryProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author QuyPN <quypn@ans-asia.com>
 */
class RepositoryProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     *
     * @return void
     */
    public function boot()
    {
    }

    public function register()
    {
        $modules = array_map('basename', \File::files(__DIR__));
        foreach ($modules as $module) {
            if (str_starts_with($module, 'I')) {
                $class = substr($module, 1, strlen($module) - 5);
                $this->app->bind("App\\Repositories\\I{$class}", "App\\Repositories\\Implements\\{$class}");
            }
        }
    }
}
