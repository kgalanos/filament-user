<?php

namespace Kgalanos\FilamentUser\Filament\Resources\UserResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserResource;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            //            Actions\DeleteAction::make(),
        ];
    }
}
