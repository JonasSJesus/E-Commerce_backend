<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('cost_price')
                    ->required()
                    ->numeric(),
                TextInput::make('stock_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('low_stock_threshold')
                    ->required()
                    ->numeric()
                    ->default(10),
                Toggle::make('active')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name'),
            ]);
    }
}
