<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$this->app->router->group(
    [
        'prefix' => 'api',
        'namespace' => 'lumilock\lumilockGateway\App\Http\Controllers'
    ],
    function ($router) {
        $router->get('/{route:.*}/', 'GatewayController@routesGet');
        // $router->get('/test', 'GatewayController@routesGet');
        $router->post('/{route:.*}/', 'GatewayController@routesPost');
        // $app->get($uri, $callback);
        // $app->post($uri, $callback);
        // $app->put($uri, $callback);
        // $app->patch($uri, $callback);
        // $app->delete($uri, $callback);
        // $app->options($uri, $callback);
    }
);
