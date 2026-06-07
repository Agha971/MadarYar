<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HamyarProfileResource\Pages;
use App\Models\HamyarProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HamyarProfileResource extends Resource
{
    protected static ?string $model = HamyarProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Services';
    protected static ?string $navigationLabel = 'Hamyar Requests';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('user.name')
                ->label('Name')
                ->disabled(),

            Forms\Components\TextInput::make('user.phone')
                ->label('Mobile')
                ->disabled(),

            Forms\Components\TextInput::make('cooperation_type')
                ->label('Cooperation Type'),

            Forms\Components\Textarea::make('skills_text')
                ->label('Skills'),

            Forms\Components\Textarea::make('description')
                ->label('Description'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Mobile'),

                Tables\Columns\TextColumn::make('cooperation_type')
                    ->label('Type'),

                Tables\Columns\IconColumn::make('reviewed_at')
                    ->label('Reviewed')
                    ->boolean(fn ($record) => $record->reviewed_at !== null),

            ])
            ->actions([

                Tables\Actions\Action::make('approve')
                    ->color('success')
                    ->action(function ($record) {

                        $record->reviewed_at = now();
                        $record->save();

                        $record->user->status = 'approved';
                        $record->user->save();
                    }),

                Tables\Actions\Action::make('reject')
                    ->color('danger')
                    ->action(function ($record) {

                        $record->reviewed_at = now();
                        $record->save();

                        $record->user->status = 'rejected';
                        $record->user->save();
                    }),

                Tables\Actions\EditAction::make(),

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHamyarProfiles::route('/'),
            'create' => Pages\CreateHamyarProfile::route('/create'),
            'edit' => Pages\EditHamyarProfile::route('/{record}/edit'),
        ];
    }
}
