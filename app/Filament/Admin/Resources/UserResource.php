<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Neighborhood;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $modelLabel = 'User';
    protected static ?string $pluralModelLabel = 'Users';
    protected static ?string $navigationGroup = 'Users Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات شناسایی')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('نام و نام خانوادگی')
                            ->required(),

                        Forms\Components\TextInput::make('phone')
                            ->label('شماره موبایل')
                            ->tel()
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('password')
                            ->label('رمز عبور')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])->columns(2),

                
                Forms\Components\Section::make('دسترسی و موقعیت')
                    ->schema([
                        // ۱. فیلد انتخاب منطقه
                        Forms\Components\Select::make('region_id')
                            ->label('انتخاب منطقه')
                            ->options(fn () => \App\Models\Neighborhood::whereNull('parent_id')->pluck('name', 'id'))
                            ->live() // باعث می‌شود با تغییر این فیلد، فرم دوباره رندر شود
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('neighborhood_id', null)) // با تغییر منطقه، محله قبلی پاک شود
                            ->dehydrated(false) // این فیلد در جدول یوزر ذخیره نمی‌شود، فقط برای فیلتر است
                            ->required(),

                        // ۲. فیلد انتخاب محله (وابسته به منطقه بالا)
                        Forms\Components\Select::make('neighborhood_id')
                            ->label('انتخاب محله')
                            ->options(function (Forms\Get $get) {
                                $regionId = $get('region_id'); // گرفتن مقدار انتخاب شده در منطقه
                                
                                if (!$regionId) {
                                    return [];
                                }

                                return \App\Models\Neighborhood::where('parent_id', $regionId)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn (Forms\Get $get) => !$get('region_id')), // تا منطقه انتخاب نشود، این فیلد غیرفعال است

                        Forms\Components\Select::make('roles')
                            ->label('نقش‌ها')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload(),

                        Forms\Components\Select::make('status')
                            ->label('وضعیت تایید')
                            ->options([
                                'pending' => 'در انتظار',
                                'approved' => 'تایید شده',
                                'rejected' => 'رد شده',
                            ])
                            ->default('approved')
                            ->required(),
                    ])->columns(2),

            

                Forms\Components\Section::make('وضعیت سیستم')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('حساب فعال')
                            ->default(true),

                        Forms\Components\Toggle::make('profile_completed')
                            ->label('تکمیل پروفایل')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Phone Number')->searchable(),

                // اصلاح شده: نمایش منطقه و محله کنار هم در جدول
                Tables\Columns\TextColumn::make('neighborhood.name')
                    ->label('Region/ Neighborhood')
                    ->description(fn (User $record): string => 
                        $record->neighborhood?->parent ? "منطقه: {$record->neighborhood->parent->name}" : 'منطقه ثبت نشده'
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),

                Tables\Columns\IconColumn::make('is_active')->label('Activation')->boolean(),
            ])
            ->filters([
                // فیلتر هوشمند بر اساس محله
                Tables\Filters\SelectFilter::make('neighborhood')
                    ->label('فیلتر محله')
                    ->options(function() {
                         return Neighborhood::whereNotNull('parent_id')
                            ->with('parent')
                            ->get()
                            ->mapWithKeys(fn($n) => [$n->id => "{$n->parent?->name} - {$n->name}"]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
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
