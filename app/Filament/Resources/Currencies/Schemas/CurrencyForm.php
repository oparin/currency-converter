<?php

namespace App\Filament\Resources\Currencies\Schemas;

use App\Modules\CurrencyConverter\Rules\Exist;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class CurrencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')->required()->maxLength(3)->unique()->rules([new Exist()]),
//                TextInput::make('name')->required(),
            ]);
    }
}
