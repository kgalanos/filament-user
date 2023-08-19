<?php

namespace Kgalanos\FilamentUser;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentUserServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-user')
            ->hasConfigFile('filament-user')
            ->hasViews('kgalanos\\filament-user')
            ->hasMigration('migrate_users_table');
    }
}
