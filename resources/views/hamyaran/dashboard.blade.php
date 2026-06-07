@extends('layouts.hamyar')

@php
    $pageTitle = 'داشبورد همیار';
    $pageDescription = 'نمای کلی حساب و شروع سریع';
@endphp

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl bg-gradient-to-l from-indigo-600 to-indigo-500 p-8 text-white shadow-lg shadow-indigo-500/20">
            <div class="max-w-2xl">
                <p class="text-sm text-indigo-100">خوش آمدید</p>
                <h2 class="mt-2 text-3xl font-black">{{ auth()->user()->name ?? 'همیار' }}</h2>
                <p class="mt-4 leading-8 text-indigo-100">
                    از این بخش می‌توانید وضعیت حساب، اطلاعات همکاری و امکانات فعال‌شده برای نقش خود را مشاهده و مدیریت کنید.
                </p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">وضعیت حساب</div>
                <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white">{{ auth()->user()->status }}</div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">نوع همکاری</div>
                <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white">{{ auth()->user()->hamyarProfile->cooperation_type ?? '-' }}</div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">محله فعالیت</div>
                <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white">{{ auth()->user()->hamyarProfile->neighborhood->name ?? 'ثبت نشده' }}</div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-black text-slate-900 dark:text-white">شروع سریع</h3>
                <div class="mt-4 space-y-3">
                    <a href="/hamyaran/profile" class="block rounded-2xl bg-slate-50 px-4 py-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        تکمیل یا ویرایش پروفایل همکاری
                    </a>
                    <a href="/hamyaran/pending" class="block rounded-2xl bg-slate-50 px-4 py-4 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        مشاهده وضعیت بررسی
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-black text-slate-900 dark:text-white">یادداشت</h3>
                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-400">
                    این داشبورد پایه است و بعداً کارت‌های فعالیت، اعلان‌ها، درخواست‌ها و امکانات مرتبط با نوع همکاری به آن اضافه می‌شود.
                </p>
            </div>
        </section>
    </div>
@endsection
