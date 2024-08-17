<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationBadge(): ?string
    {
        // /** @var Channel $model  */
        $model = static::getModel();

        return (string) $model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('name')
                            ->content(fn ($record) => $record->name),
                        Forms\Components\Placeholder::make('email')
                            ->content(fn ($record) => $record->email),
                        Forms\Components\Placeholder::make('email_verified_at')
                            ->content(fn ($record) => $record->email_verified_at->format('Y-m-d H:i:s')),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invites_count')
                    ->label('Invites')
                    ->counts('invites')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('followers_count')
                    ->label('Followers')
                    ->counts('followers')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('followings_count')
                    ->label('Following')
                    ->counts('followings')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChannelsRelationManager::class,
            RelationManagers\PostsRelationManager::class,
            RelationManagers\CommentsRelationManager::class,
            RelationManagers\FollowersRelationManager::class,
            RelationManagers\FollowingsRelationManager::class,
            RelationManagers\ProfilesRelationManager::class,
            RelationManagers\FinancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
