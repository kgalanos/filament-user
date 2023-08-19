<?php

namespace Kgalanos\FilamentUser\Filament\Pages\Auth;

//use Filament\Pages\Page;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class Register extends \Filament\Pages\Auth\Register
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
            ])
            ->statePath('data');
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('Phone'))
            ->required()
            ->tel()
            ->maxLength(25)
            ->minLength(10)
            ->unique($this->getUserModel());
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label(__('Username'))
            ->alphaNum()
            ->required()
            ->maxLength(25)
            ->minLength(4)
            ->unique($this->getUserModel());
    }
}
