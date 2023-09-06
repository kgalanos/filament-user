# Add username or email to login filamentphp panel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kgalanos/filament-user.svg?style=flat-square)](https://packagist.org/packages/kgalanos/filament-user)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kgalanos/filament-user/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kgalanos/filament-user/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kgalanos/filament-user/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kgalanos/filament-user/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kgalanos/filament-user.svg?style=flat-square)](https://packagist.org/packages/kgalanos/filament-user)

Add fields ulid(do not remove id),username,phone and phone_verified_at to User Model and you may login with username/email in filamentphp panel.
Also installs and configure 
````bash
        "alperenersoy/filament-export": "*",
        "stechstudio/filament-impersonate": "^3.0",
        "bezhansalleh/filament-shield": "*"
````

## Installation

You can install the package via composer:

```bash
composer require kgalanos/filament-user
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-user-migrations"
```
```bash
php artisan migrate
```
You can update Model User in config\auth.php with:
```php
'model' => \Kgalanos\FilamentUser\Models\User::class,
```
or
you can update 
```php
App\Models\User
with
class User extends \Kgalanos\FilamentUser\Models\User implements FilamentUser
{
    use HasFilamentShield, HasRoles;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar_url',
        'phone',
    ];
.....
}
```
Install the Filament Panel Builder by running
```bash
php artisan filament:install --panels
```
You can update App\Providers\Filament\AdminPanelProvider with:
```php
            ->login(\Kgalanos\FilamentUser\Filament\Pages\Auth\Login::class)
            ->registration(\Kgalanos\FilamentUser\Filament\Pages\Auth\Register::class)
            ->passwordReset()
            ->profile(\Kgalanos\FilamentUser\Filament\Pages\Auth\EditProfile::class)

            ->discoverPages(base_path('vendor/kgalanos/filament-user/src/Filament/Pages'),'Kgalanos\\FilamentUser\\Filament\\Pages')
```
You can publish the config file with:

```bash
php artisan vendor:publish --tag=filament-shield-config
```
```bash
php artisan vendor:publish --tag="filament-user-config"
```

This is the contents of the published config file:

```php
return [
];
```
For the Shield
```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
        ]);
}
```
```bash
php artisan shield:install
```
If there is no user id DB it ask you to create an admin.

```bash
php artisan make:filament-resource User 
```
change the App\Filament\Resources
```php
class UserResource extends \Kgalanos\FilamentUser\Filament\Resources\UserResource
{

    public static function form(Form $form): Form
    {
        $form= parent::form($form);
        return $form;
    }

    public static function table(Table $table): Table
    {
        $table=parent::table($table);
        return $table;
    }
}
````
Optionally you can use Kgalanos\FilamentUser\Filament\Widgets\ApplicationInfoWidget
update App\Providers\Filament\AdminPanelProvider with:
```php
            ->widgets([
                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
                ApplicationInfoWidget::class,
            ])
```
Optionally, you can publish the views,if you use ApplicationInfoWidget::class you have to publish the views  
using

```bash
php artisan vendor:publish --tag="filament-user-views"
```

## Usage


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Kostas Galanos](https://github.com/kgalanos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
