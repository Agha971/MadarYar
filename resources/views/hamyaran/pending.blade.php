@extends('layouts.hamyar')

@php
    $pageTitle = 'وضعیت بررسی حساب';
    $pageDescription = 'حساب شما در حال بررسی توسط ادمین است';
@endphp

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-amber-200 bg-white p-8 shadow-sm dark:border-amber-900/40 dark:bg-slate-900">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-xl dark:bg-amber-500/10">
                    ⏳
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 dark:text-white">درخواست شما ثبت شده است</h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400">بعد از بررسی و تأیید، دسترسی کامل برای شما فعال می‌شود.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <div class="text-xs text-slate-500 dark:text-slate-400">نام</div>
                    <div class="mt-1 font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <div class="text-xs text-slate-500 dark:text-slate-400">وضعیت حساب</div>
                    <div class="mt-1 font-bold text-amber-600 dark:text-amber-400">{{ auth()->user()->status }}</div>
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm leading-7 text-slate-600 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-300">
                اطلاعات هویتی و همکاری شما توسط تیم مدیریت بررسی می‌شود. در این مرحله ممکن است فقط به امکانات محدود دسترسی داشته باشید.
            </div>

            <form action="{{ route('hamyaran.logout') }}" method="POST" class="mt-6">
                @csrf
                <button class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">
                    خروج از حساب
                </button>
            </form>
        </div>
    </div>
@endsection
