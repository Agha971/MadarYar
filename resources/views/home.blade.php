@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="inline-flex rounded-full bg-indigo-100 px-4 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                        پلتفرم ارتباط و حمایت محلی
                    </span>

                    <h1 class="mt-6 text-4xl font-black leading-tight text-slate-900 dark:text-white sm:text-5xl">
                        همراهی هوشمند برای
                        <span class="text-indigo-600 dark:text-indigo-400">مادران</span>
                        با کمک شبکه‌ای از
                        <span class="text-rose-500 dark:text-rose-400">همیاران</span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                        همیار مادر بستری برای ثبت‌نام مادران، جذب و ارزیابی همیاران، و شکل‌دادن به یک شبکه محلی از حمایت و همکاری است.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="/register" class="inline-flex rounded-2xl bg-rose-500 px-6 py-3 text-sm font-bold text-white transition hover:bg-rose-600">
                            ثبت‌نام مادران
                        </a>

                        <a href="/hamyaran/register" class="inline-flex rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-indigo-700">
                            ثبت‌نام همیاران
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="text-sm font-bold text-slate-900 dark:text-white">برای مادران</div>
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-400">
                            ثبت‌نام ساده، تکمیل پروفایل، ثبت اطلاعات فرزندان و دسترسی مرحله‌ای به خدمات.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="text-sm font-bold text-slate-900 dark:text-white">برای همیاران</div>
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-400">
                            ثبت‌نام تخصصی‌تر، معرفی توانمندی‌ها، بررسی ادمین و ورود به فضای همکاری.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:col-span-2">
                        <div class="text-sm font-bold text-slate-900 dark:text-white">رشد تدریجی و معماری‌پذیر</div>
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-400">
                            ساختار پروژه به‌گونه‌ای چیده شده که بعداً نقش‌ها، درخواست‌ها، سرویس‌ها و همکاری‌های محلی بدون آشفتگی اضافه شوند.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
