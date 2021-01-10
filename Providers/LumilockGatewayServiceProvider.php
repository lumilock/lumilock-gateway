<?php

namespace lumilock\lumilockGateway\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class LumilockGatewayServiceProvider extends ServiceProvider
{

   /**
    * Bootstrap the application services.
    *
    * @return void
    */
   public function boot()
   {
   }

   /**
    * Register the application services.
    *
    * @return void
    */
   public function register()
   {
      //Register Our Package routes
      include __DIR__ . '/../Routes/web.php';
   }


   /**
    * Get the services provided by the provider.
    *
    * @return array
    */
   // public function provides()
   // {
   //    return ['lumilock'];
   // }
}
