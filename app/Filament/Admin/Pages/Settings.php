<?php

namespace App\Filament\Admin\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'System';
    protected static string $view = 'filament.admin.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::first()?->data ?? [];

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Tabs::make('Settings')
                    ->tabs([

                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([

                                Forms\Components\TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->required(),

                                Forms\Components\FileUpload::make('site_logo')
                                    ->label('Site Logo')
                                    ->image()
                                    ->directory('logos'),

                            ]),

                        Forms\Components\Tabs\Tab::make('Support')
                            ->schema([

                                Forms\Components\TextInput::make('support_email')
                                    ->email(),

                                Forms\Components\TextInput::make('support_phone'),

                            ]),

                        Forms\Components\Tabs\Tab::make('Events')
                            ->schema([

                                Forms\Components\TextInput::make('default_event_capacity')
                                    ->numeric()
                                    ->default(20),

                                Forms\Components\Toggle::make('events_enabled')
                                    ->default(true),

                            ]),

                        Forms\Components\Tabs\Tab::make('System')
                            ->schema([

                                Forms\Components\Toggle::make('maintenance_mode')
                                    ->label('Maintenance Mode'),

                            ]),

                    ])
                    ->columnSpanFull()

            ])
            ->statePath('data');
    }

    public function save()
    {
        Setting::setAll($this->form->getState());

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

}
