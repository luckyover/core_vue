<?php

namespace App\api;

/**
 * ApiServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author QuyPN <quypn@ans-asia.com>
 */
class ApiServiceProvider extends \Illuminate\Support\ServiceProvider
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
        }
    }

    public function register()
    {
        // $modules = array_map('basename', \File::directories(__DIR__));
        // foreach ($modules as $module) {
        //     if ($module == 'Error') {
        //         continue;
        //     }
        //     $models = array_map('basename', \File::directories(__DIR__.'/'.$module.'/Models'));
        //     foreach ($models as $model) {
        //         $this->app->bind("App\api\\v1\\{$module}\Models\\{$model}\I{$model}Model", "App\api\\v1\\{$module}\Models\\{$model}\\{$model}Model");
        //     }
        // }
    }
}
