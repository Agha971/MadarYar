@extends('layouts.mother')

@php
    $pageTitle = 'داشبورد مادر';
    $pageDescription = 'نمای کلی وضعیت حساب و اطلاعات شما';
@endphp

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl bg-gradient-to-l from-rose-500 to-rose-400 p-8 text-white shadow-lg shadow-rose-500/20">
            <div class="max-w-2xl">
                <p class="text-sm text-rose-100">خوش آمدید</p>
                <h2 class="mt-2 text-3xl font-black">{{ auth()->user()->name ?? 'مادر' }}</h2>
                <p class="mt-4 leading-8 text-rose-100">
                    از این بخش می‌توانید اطلاعات خود را تکمیل کنید، فرزندان را ثبت کنید و به امکانات فعال‌شده دسترسی داشته باشید.
                </p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">وضعیت حساب</div>
                <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white">{{ auth()->user()->status }}</div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">تکمیل پروفایل</div>
                <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white">
                    {{ auth()->user()->profile_completed ? 'بله' : 'خیر' }}
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">تعداد فرزندان</div>
                <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white">
                    {{ auth()->user()->children->count() ?? 0 }}
                </div>
            </div>
        </section>
    </div>
@endsection
