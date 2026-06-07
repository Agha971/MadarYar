@extends('layouts.app')

@section('body')
    <div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
        @include('components.mother-sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            @include('components.mother-topbar', [
                'pageTitle' => $pageTitle ?? 'پنل مادر',
                'pageDescription' => $pageDescription ?? 'مدیریت اطلاعات و پیگیری خدمات'
            ])

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>
@endsection
