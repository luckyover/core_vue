<?php

namespace App\Modules;

/**
 * ModuleServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author QuyPN <quypn@ans-asia.com>
 */
class ModuleServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     *
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views
        $modules = array_map('basename', \File::directories(__DIR__));
        foreach ($modules as $module) {
            // Load the routes for each of the modules
            if (file_exists(__DIR__ . '/' . $module . '/routes.php')) {
                include __DIR__ . '/' . $module . '/routes.php';
            }
            // Load the views
            $view_path = __DIR__ . '/' . $module . '/Views';
            if (is_dir($view_path)) {
                $this->loadViewsFrom($view_path, $module);
            }
        }
    }

    public function register()
    {
    }
}
