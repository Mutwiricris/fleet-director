<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DirectorLogin extends BaseLogin
{
    /**
     * Customize the form schema for director login.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->getEmailFormComponent()
                    ->label('Director Email')
                    ->placeholder('Enter your director email'),
                $this->getPasswordFormComponent()
                    ->placeholder('Enter your password'),
                $this->getRememberFormComponent(),
            ]);
    }

    /**
     * Get the heading for the login page.
     */
    public function getHeading(): string
    {
        return 'Director Login';
    }

    /**
     * Get the subheading for the login page.
     */
    public function getSubHeading(): string
    {
        return 'Sign in to your director account';
    }
}
