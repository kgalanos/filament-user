<?php

namespace Kgalanos\FilamentUser\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ulid')->readOnly(),
                TextInput::make('username')
                    ->label(__('Username'))
                    ->alphaNum()
                    ->readOnly(function (TextInput $component): bool {
                        // if is new Record
                        if (is_null($component->getRecord())) {
                            return false;
                        }
                        // if is existing record and username is empty
                        return config('filament-user.IsUsernameEditable') ? false : ! is_null($component->getRecord()['username']);
                    })
                    ->required()
                    ->maxLength(25)
                    ->minLength(4)
                    ->unique(ignorable: fn ($record) => $record)
                    ->live(true)
                    ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
                        $livewire->validateOnly($component->getStatePath());
                    }),

                TextInput::make('name')
                    ->label(__('filament-panels::pages/auth/register.form.name.label'))
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                /*
                 * This must add to arag
                TextInput::make('syms_count')->readOnly(),
                */
                TextInput::make('email')
                    ->label(__('filament-panels::pages/auth/register.form.email.label'))
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignorable: fn ($record) => $record)
                    ->live(true)
                    ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
                        $livewire->validateOnly($component->getStatePath());
                    }),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->required()
                    ->nullable()
                    ->tel()
                    ->maxLength(25)
                    ->minLength(10)
                    ->unique(ignorable: fn ($record) => $record)
                    ->live(true)
                    ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
                        $livewire->validateOnly($component->getStatePath());
                    }),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()->preload(),
                TextInput::make('password')
                    ->label(__('filament-panels::pages/auth/register.form.password.label'))
                    ->password()
                    ->required()
                    ->nullable()
                    ->rule(Password::default())
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->same('passwordConfirmation')
                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
                TextInput::make('passwordConfirmation')
                    ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
                    ->password()
                    ->required()
                    ->nullable()
                    ->dehydrated(false),

            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('roles.name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->label(''),
                Impersonate::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                    FilamentExportBulkAction::make('export'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}/view'),
        ];
    }
    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['username', 'phone', 'email', 'name'];
    }

    public static function canDelete(Model $record): bool
    {
        return false;
        //        return parent::canDelete($record); // TODO: Change the autogenerated stub
    }
}
