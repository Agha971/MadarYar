@extends('layouts.app')

@section('body')
    <div class="flex min-h-screen flex-col">
        @include('components.public-header')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('components.public-footer')
    </div>
@endsection
