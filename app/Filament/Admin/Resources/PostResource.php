<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\User;
use App\Models\Neighborhood;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Community';

    protected static ?string $navigationLabel = 'Posts';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $pluralModelLabel = 'Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Post Information')
                    ->schema([

                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('region_id')
                            ->label('Region')
                            ->options(
                                Neighborhood::whereNull('parent_id')->pluck('name','id')
                            )
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('neighborhood_id', null))
                            ->required(),

                        Select::make('neighborhood_id')
                            ->label('Neighborhood')
                            ->options(function (callable $get) {
                                $region = $get('region_id');

                                if (!$region) {
                                    return [];
                                }

                                return Neighborhood::where('parent_id', $region)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),


                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('content')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),

                        Select::make('type')
                            ->options([
                                'post' => 'Post',
                                'question' => 'Question',
                                'announcement' => 'Announcement',
                            ])
                            ->default('post')
                            ->required(),

                        Toggle::make('is_approved')
                            ->label('Approved')
                            ->default(true),

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('neighborhood.name')
                    ->label('Neighborhood')
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'question' => 'warning',
                        'announcement' => 'danger',
                        default => 'primary',
                    }),

                IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),

            ])

            ->filters([

                SelectFilter::make('type')
                    ->options([
                        'post' => 'Post',
                        'question' => 'Question',
                        'announcement' => 'Announcement',
                    ]),

                SelectFilter::make('neighborhood')
                    ->relationship('neighborhood', 'name'),

                SelectFilter::make('user')
                    ->relationship('user', 'name'),

            ])

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (Post $record) => $record->update([
                        'is_approved' => true
                    ]))
                    ->visible(fn (Post $record) => !$record->is_approved),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(fn (Post $record) => $record->update([
                        'is_approved' => false
                    ]))
                    ->visible(fn (Post $record) => $record->is_approved),

            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

                Tables\Actions\BulkAction::make('approve')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check')
                    ->action(fn ($records) => $records->each->update([
                        'is_approved' => true
                    ])),

                Tables\Actions\BulkAction::make('reject')
                    ->label('Reject Selected')
                    ->icon('heroicon-o-x-mark')
                    ->action(fn ($records) => $records->each->update([
                        'is_approved' => false
                    ])),
            ])

            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // بعداً RelationManager برای comments اینجا اضافه می‌کنیم
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
