# Lumilock

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Dev Version on Packagist][ico-version-dev]][link-packagist]

## 📚 Installation
Create a .env file, copy all contents in .env.example into the .env file and add your database configurations.

In boostrap/app.php uncomment the facades and eloquent method.

```php
//before

// $app->withFacades();

// $app->withEloquent();

//after

$app->withFacades();

$app->withEloquent();
```


Make some changes to `bootstrap/app.php`.
```php
//before
// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

//After
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
]);
```

```php
 // Add these lines
$app->register(lumilock\lumilockGateway\Providers\LumilockGatewayServiceProvider::class);
```

Add CORS Middleware to `bootstrap/app.php`.
```php
  $app->middleware([
      \lumilock\lumilockGateway\App\Http\Middleware\CorsMiddleware::class
  ]);
```

## .Env
add these env var in your .env project file
```.env
AUTH_URI=<http://your_uri_api>
SSO_SECRET=<your_auth_accepted_secret>
```
## 🏗️ Create a package
https://blog.cloudoki.com/creating-a-lumen-package/

## 📰 Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## 👨‍👩‍👧‍👦 Credits

- [lumilock (Thibaud PERRIN)][link-author]


## 📝 License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/perrinthibaud/laravlock.svg
[ico-version-dev]: https://img.shields.io/packagist/vpre/perrinthibaud/laravlock.svg

[link-packagist]: https://packagist.org/packages/perrinthibaud/laravlock
[link-author]: https://github.com/lumilock
[link-contributors]: ../../contributors]