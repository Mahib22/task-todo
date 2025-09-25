<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Register;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomRegister extends Register
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getUsernameFormComponent()
    {
        return TextInput::make('username')
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel());
    }
}
