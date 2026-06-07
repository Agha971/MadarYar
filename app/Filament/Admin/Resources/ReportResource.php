<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Moderation';

    protected static ?string $navigationLabel = 'Reports';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('reporter_id')
                ->label('Reporter')
                ->relationship('reporter', 'name')
                ->searchable()
                ->required(),


            Forms\Components\Select::make('reportable_type')
                ->label('Content Type')
                ->options([
                    'App\Models\Post' => 'Post',
                    'App\Models\Comment' => 'Comment',
                    'App\Models\Event' => 'Event',
                    'App\Models\User' => 'User',
                ])
                ->required(),

            Forms\Components\TextInput::make('reportable_id')
                ->label('Content ID')
                ->numeric()
                ->required(),
    
            Forms\Components\Select::make('reason')
                ->options([
                    'spam' => 'Spam',
                    'inappropriate' => 'Inappropriate Content',
                    'harassment' => 'Harassment',
                    'misinformation' => 'Misinformation',
                    'other' => 'Other',
                ])
                ->required(),

            Forms\Components\Textarea::make('description')
                ->rows(4)
                ->columnSpanFull(),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'reviewed' => 'Reviewed',
                    'dismissed' => 'Dismissed',
                ])
                ->default('pending')
                ->required(),

            Forms\Components\Select::make('reviewed_by')
                ->label('Reviewed By')
                ->relationship('reviewer', 'name')
                ->searchable(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reporter')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reportable_type')
                    ->label('Content Type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reason')
                    ->badge()
                    ->color('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'reviewed',
                        'gray' => 'dismissed',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reported At')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'dismissed' => 'Dismissed',
                    ]),

                Tables\Filters\SelectFilter::make('reason')
                    ->options([
                        'spam' => 'Spam',
                        'inappropriate' => 'Inappropriate',
                        'harassment' => 'Harassment',
                        'misinformation' => 'Misinformation',
                    ]),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
