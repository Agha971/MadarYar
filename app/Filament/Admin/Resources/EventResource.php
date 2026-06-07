<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\Neighborhood;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Community';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('user_id')
                ->label('Creator')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('region_id')
                ->label('Region')
                ->options(
                    Neighborhood::whereNull('parent_id')->pluck('name', 'id')
                )
                ->live()
                ->afterStateUpdated(fn ($set) => $set('neighborhood_id', null))
                ->required(),

            Forms\Components\Select::make('neighborhood_id')
                ->label('Neighborhood')
                ->options(function ($get) {
                    return Neighborhood::where('parent_id', $get('region_id'))
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->rows(4)
                ->columnSpanFull(),

            Forms\Components\DateTimePicker::make('event_date')
                ->required(),

            Forms\Components\TextInput::make('location')
                ->maxLength(255),

            Forms\Components\TextInput::make('capacity')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('type')
                ->label('Event Type')
                ->options([
                    'community' => 'Community Event',
                    'official' => 'Official Program',
                ])
                ->required(),

                Forms\Components\Select::make('category')
                ->label('Event Category')
                ->options([
                    'workshop' => 'Workshop',
                    'meeting' => 'Meeting',
                    'activity' => 'Activity',
                    'training' => 'Training',
                    'kids_program' => 'Kids Program',
                    'other' => 'Other',
                ])
                ->searchable()
                ->required(),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('neighborhood.name')
                    ->label('Neighborhood')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creator'),

                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                Tables\Columns\TextColumn::make('category')
                    ->badge(),


                Tables\Columns\TextColumn::make('event_date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('capacity')
                    ->label('Capacity'),

                Tables\Columns\TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Registered'),

                Tables\Columns\TextColumn::make('capacity_status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) =>
                        $record->registrations()->count() . ' / ' . $record->capacity
                    )
                    ->badge()
                    ->color(fn ($record) =>
                        $record->registrations()->count() >= $record->capacity
                            ? 'danger'
                            : 'success'
                    ),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
