<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Post\PostStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    //    protected static ?string $navigationParentItem = 'Channels';

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
                        Forms\Components\Placeholder::make('user.name')
                            ->label('User name')
                            ->content(fn ($record) => $record->user->name),
                        Forms\Components\Placeholder::make('channel.name')
                            ->label('Channel name')
                            ->content(fn ($record) => $record->channel->name),
                        Forms\Components\Textarea::make('blocks')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('is_pinned')
                            ->content(fn ($record): string => $record->is_pinned ? 'Yes' : 'No'),
                        Forms\Components\Select::make('status')
                            ->options(PostStatus::class)
                            ->selectablePlaceholder(false)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('channel.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('replies_count')
                    ->label('Comments')
                    ->counts('replies')
                    ->badge(),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Likes')
                    ->counts('likes')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bookmarks_count')
                    ->label('Bookmarks')
                    ->counts('bookmarks')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\RepliesRelationManager::class,
            RelationManagers\BookmarksRelationManager::class,
            RelationManagers\LikesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
