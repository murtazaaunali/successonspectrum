<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapParentRoutes();

        $this->mapFemployeeRoutes();

        $this->mapFranchiseRoutes();

        $this->mapAdminRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin', 'auth:admin'],
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }

    protected function mapFranchiseRoutes()
    {
        Route::group([
            'middleware' => ['web', 'franchise', 'auth:franchise'],
            'prefix' => 'franchise',
            'as' => 'franchise.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/franchise.php');
        });
    }
    
    protected function mapFemployeeRoutes()
    {
        Route::group([
            'middleware' => ['web', 'femployee', 'auth:femployee'],
            'prefix' => 'femployee',
            'as' => 'femployee.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/femployee.php');
        });
    }    

    protected function mapParentRoutes()
    {
        Route::group([
            'middleware' => ['web', 'parent', 'auth:parent'],
            'prefix' => 'parent',
            'as' => 'parent.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/parent.php');
        });
    }

}
