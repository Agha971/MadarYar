<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HamyarTicketResource\Pages;
use App\Models\HamyarTicket;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HamyarTicketResource extends Resource
{
    protected static ?string $model = HamyarTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Services';
    protected static ?string $navigationLabel = 'Hamyar Tickets';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('user_id')
                ->label('Mother')
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

            Forms\Components\Select::make('hamyar_id')
                ->label('Hamyar')
                ->options(User::pluck('name', 'id'))
                ->searchable()
                ->placeholder('Not assigned'),

            Forms\Components\TextInput::make('subject')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('message')
                ->required()
                ->rows(4),

            Forms\Components\Select::make('status')
                ->options([
                    'open' => 'Open',
                    'answered' => 'Answered',
                    'closed' => 'Closed',
                ])
                ->default('open')
                ->required(),

        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Mother')
                    ->searchable(),

                Tables\Columns\TextColumn::make('hamyar.name')
                    ->label('Hamyar')
                    ->badge()
                    ->color('success')
                    ->placeholder('Unassigned'),

                Tables\Columns\TextColumn::make('neighborhood.name')
                    ->label('Neighborhood'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'open' => 'danger',
                        'answered' => 'warning',
                        'closed' => 'success',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'answered' => 'Answered',
                        'closed' => 'Closed',
                    ]),

                Tables\Filters\SelectFilter::make('hamyar')
                    ->relationship('hamyar', 'name'),

                Tables\Filters\SelectFilter::make('neighborhood')
                    ->relationship('neighborhood', 'name'),

            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('answer')
                    ->label('Mark Answered')
                    ->color('warning')
                    ->action(fn ($record) => $record->update([
                        'status' => 'answered'
                    ]))
                    ->visible(fn ($record) => $record->status === 'open'),

                Tables\Actions\Action::make('close')
                    ->label('Close')
                    ->color('success')
                    ->action(fn ($record) => $record->update([
                        'status' => 'closed'
                    ]))
                    ->visible(fn ($record) => $record->status !== 'closed'),

            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHamyarTickets::route('/'),
            'create' => Pages\CreateHamyarTicket::route('/create'),
            'edit' => Pages\EditHamyarTicket::route('/{record}/edit'),
        ];
    }
}
