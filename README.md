# EZ Laravel ModelServices

This package provides some default service functionality for services based on Models. I tend to use these a lot as a kind of Repository class.

I also ran into the issue of (deep) collections not properly rendering to JSON when used in Vue components. So instead of relying on whatever Laravel's doing in the background I decided to manually define my extra properties using a preload method in my model services which handles adding/editing attributes I need in my Vue components.

## Installation

Run the following command in your project directory to install the package:
```
composer require ez-laravel/model-services
```

## Usage

Now you can define your model-based services like this:
```php
<?php

namespace App\Services\ModelServices;

use EZ\ModelServices\Traits\ModelServiceGetters;
use EZ\ModelServices\Contracts\ModelServiceContract;

class UserService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;

    public function __construct()
    {
        $this->model = "App\Models\User";
    }

    public function preload($instance)
    {
        return $instance;
    }
}
```

## Methods
Once you've registered your service the following methods will be automatically available:
```php
$users = Users::getAll();
$users = Users::getAllPreloaded();
$numUsers = Users::countAll();
$user = Users::find($id);
$user = Users::findBy($field, $value);
$user = Users::findPreloaded($id);
$user = Users::findPreloadedBy($field, $value);
```

## Registering a Model Service 

To make the class available you should create a Facade and register both the service and the facade in your application.

#### Register your service
By updating your `app\Providers\AppServiceProvider.php` file to register the service in the IoC container.
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ModelServices\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("users", function() {
            return new UserService;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
```

#### Create a facade
For example:
```php
<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UsersFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "users";
    }
}
```

#### Register the facade
Finally update your `app/config/app.php` configuration file to register the facade:
```php
<?php

return [
    ...
    'aliases' => [
        ...
        'Users' => App\Facades\UsersFacade::class,
    ],
];
```

## Contribute

I'm looking for feedback!

As I'm not entirely sure this is the best approach to solve my initial problem (missing attributes in vue components & needing some type of repository classes).

Currently all records are retrieved to reduce the amount of queries executed when the model services are used a lot. This probably isn't the best way to go around it and I'm looking for a better way. So if you got any tips feel free to hit me up or make a PR!