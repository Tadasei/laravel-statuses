
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
* Define a One-to-Many relationship with your model (one `App\Models\Status` has many `App\Models\YourModel`).
* Add your model class name to the `App\Enums\StatusableType` enum.

This allows full flexibility in defining how your application links statuses to models.

### Running migrations

To create the related `statuses` table, run the generated migration using the following command:

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

The usage is the same as any regular One-to-Many relationship:

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

$status->users()->save($user);
```

## Customization

The generated code serves as a starting point. You can customize and extend it according to your project's requirements. Modify the generated utilities as needed.

## Contributing

Contributions are welcome! If you have suggestions, bug reports, or feature requests, please open an issue on the GitHub repository.

## License

This package is open-source software licensed under the [MIT license](LICENSE).
