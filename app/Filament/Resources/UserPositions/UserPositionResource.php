<?php

namespace App\Filament\Resources\UserPositions;

use App\Filament\Resources\UserPositions\Pages\ListUserPositionActivities;
use App\Filament\Resources\UserPositions\Pages\ManageUserPositions;
use App\Models\Position;
use App\Models\User;
use App\Models\UserPosition;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserPositionResource extends Resource
{
    protected static ?string $model = UserPosition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'uuid'))
                    ->required()
                    ->searchable(),
                Select::make('position_id')
                    ->label('Position')
                    ->required()
                    ->searchable()
                    ->options(function ($get, $state, $record) {
                        $userId = $get('user_id');

                        if (!$userId) return [];

                        $usedPositionIds = UserPosition::where('user_id', $userId)
                            ->when($record, fn($query) => $query->where('uuid', '!=', $record->uuid))
                            ->pluck('position_id')
                            ->toArray();

                        return Position::whereNotIn('uuid', $usedPositionIds)
                            ->orWhere('uuid', $state)
                            ->pluck('name', 'uuid')
                            ->toArray();
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('position.name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('position')
                    ->relationship('position', 'name')
                    ->searchable()
                    ->preload()
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')
                    ->url(fn($record) => UserPositionResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUserPositions::route('/'),
            'activities' => ListUserPositionActivities::route('/{record}/activities'),
        ];
    }
}
