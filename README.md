
# Tadasei/laravel-statuses

This package provides stubs for statuses association to Eloquent models.

## Features

- Quickly generate statuses handling utilities.
- Customize and extend generated code to fit your project's needs.
- Improve development efficiency by eliminating repetitive tasks.

## Installation

You can install the package via Composer by running:

```bash
composer require tadasei/laravel-statuses --dev
```

### Publishing statuses handling utilities

To publish statuses handling utilities, use the following command:

```bash
php artisan statuses:install
```

### Configuring Statusable Models

To extend or define which models are considered *statusable*:
* Add the following relationship definition to your model:
    ```php
    use Illuminate\Database\Eloquent\Relations\MorphToMany;

    /**
     * Get all of the statuses for your model.
     */
    public function statuses(): MorphToMany
    {
        return $this->morphToMany(Status::class, 'statusable')->using(Statusable::class)->withTimestamps();
    }
    ```
* Add the following relationship definition to `App\Models\Status`:
    ```php
    use Illuminate\Database\Eloquent\Relations\MorphToMany;

    /**
     * Get all of your models that are assigned this status.
     */
    public function yourModels(): MorphToMany
    {
        return $this->morphedByMany(YourModel::class, 'statusable')->using(Statusable::class)->withTimestamps();
    }
    ```
* Add your model class name to the `App\Enums\StatusableType` enum.

This allows full flexibility in defining how your application links statuses to models.

### Running migrations

To create the related `statuses` and `statusables` tables, run the generated migrations using the following command:

```bash
php artisan migrate
```

### Register CRUD routes

This package generates a `routes/resources/status.php` route file among its utilities. You can include this file in your `routes/web.php` or `routes/api.php` to enable authenticated and authorized `App\Models\Status` model CRUD operations.

```php
// in routes/api.php or routes/web.php
require __DIR__ . "/resources/status.php";
```

## Usage:

```php
use App\Models\{Status, User};

$status = Status::create([
    "statusable_type" => User::class,
    "name" => "Initial status",
    "color" => "#858662",
    "is_initial" => true,
    "is_final" => false,
]);

$user = User::first();

$user->statuses()->attach($status);

$user->statuses()->detach($status);

$user->statuses()->sync([$status->id]);
```

## Customization

The generated code serves as a starting point. You can customize and extend it according to your project's requirements. Modify the generated utilities as needed.

## Contributing

Contributions are welcome! If you have suggestions, bug reports, or feature requests, please open an issue on the GitHub repository.

## License

This package is open-source software licensed under the [MIT license](LICENSE).
