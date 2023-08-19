<?php

namespace Kgalanos\FilamentUser\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use function Filament\Support\is_slot_empty;

class EditProfile extends \Filament\Pages\Auth\EditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getUserNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPhoneFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('Phone'))
            ->required()
            ->tel()
            ->maxLength(25)
            ->minLength(10)
            ->unique(ignoreRecord: true);
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label(__('Username'))
            ->readOnly(fn(TextInput $component):bool =>
                config('filament-user.IsUsernameEditable') ? false : ! is_null($component->getRecord()['username'])
            )
            ->alphaNum()
            ->required()
            ->maxLength(25)
            ->minLength(4)
            ->unique(ignoreRecord: true);
    }
}
