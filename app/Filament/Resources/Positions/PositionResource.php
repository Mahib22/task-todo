<?php

namespace App\Filament\Resources\Positions;

use App\Filament\Resources\Positions\Pages\ListPositionActivities;
use App\Filament\Resources\Positions\Pages\ManagePositions;
use App\Models\Position;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')
                    ->url(fn($record) => PositionResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePositions::route('/'),
            'activities' => ListPositionActivities::route('/{record}/activities'),
        ];
    }
}
