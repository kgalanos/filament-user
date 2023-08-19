<?php

namespace Kgalanos\FilamentUser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kgalanos\FilamentUser\FilamentUser
 */
class FilamentUser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kgalanos\FilamentUser\FilamentUser::class;
    }
}
