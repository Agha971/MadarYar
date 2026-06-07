<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\HamyarTicket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->color('primary'),

            Stat::make('Hamyar', User::role('hamyar')->count())
                ->description('Neighborhood helpers')
                ->color('success'),

            Stat::make('Open Tickets', HamyarTicket::where('status','open')->count())
                ->description('Need attention')
                ->color('danger'),

            Stat::make('Closed Tickets', HamyarTicket::where('status','closed')->count())
                ->description('Resolved')
                ->color('success'),

            Stat::make('Posts', Post::count())
                ->color('info'),

            Stat::make('Events', Event::count())
                ->color('warning'),

        ];
    }
}
