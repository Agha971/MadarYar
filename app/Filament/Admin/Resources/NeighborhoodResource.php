<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NeighborhoodResource\Pages;
use App\Models\Neighborhood;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

use Filament\Resources\Resource;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class NeighborhoodResource extends Resource
{
    protected static ?string $model = Neighborhood::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Location';

    protected static ?string $navigationLabel = 'Regions & Neighborhoods';

    protected static ?string $modelLabel = 'Neighborhood';

    protected static ?string $pluralModelLabel = 'Neighborhoods';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Location Info')
                    ->schema([

                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),

                        Select::make('parent_id')
                            ->label('Region')
                            ->options(
                                Neighborhood::whereNull('parent_id')
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->placeholder('Leave empty if this is a Region')
                            ->helperText('اگر خالی باشد یعنی منطقه است'),

                    ])
                    ->columns(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->getStateUsing(fn ($record) => $record->parent_id ? 'Neighborhood' : 'Region')
                    ->badge()
                    ->color(fn ($state) => $state === 'Region' ? 'success' : 'info'),

                TextColumn::make('parent.name')
                    ->label('Region')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->since()
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('parent_id')
                    ->label('Filter by Region')
                    ->options(
                        Neighborhood::whereNull('parent_id')
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    ),

            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ])

            ->bulkActions([

                Tables\Actions\DeleteBulkAction::make(),

            ])

            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [

            'index' => Pages\ListNeighborhoods::route('/'),

            'create' => Pages\CreateNeighborhood::route('/create'),

            'edit' => Pages\EditNeighborhood::route('/{record}/edit'),

        ];
    }
}
