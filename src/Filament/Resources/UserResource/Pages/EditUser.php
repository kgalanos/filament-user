<?php

namespace Kgalanos\FilamentUser\Filament\Resources\UserResource\Pages;

use Kgalanos\FilamentUser\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}