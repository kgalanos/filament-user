<?php

namespace Kgalanos\FilamentUser\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kgalanos\FilamentUser\Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
