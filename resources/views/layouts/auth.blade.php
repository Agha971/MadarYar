@extends('layouts.app')

@section('body')
    <div class="relative min-h-screen overflow-hidden bg-slate-50 dark:bg-slate-950">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(99,102,241,0.12),_transparent_35%),radial-gradient(circle_at_bottom_left,_rgba(244,63,94,0.10),_transparent_30%)]"></div>

        <div class="relative mx-auto flex min-h-screen max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-lg font-bold text-white shadow-sm">
                        ه
                    </div>
                    <div>
                        <div class="text-base font-extrabold text-slate-900 dark:text-white">همیار مادر</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">خوش آمدید</div>
                    </div>
                </a>

                @include('components.theme-toggle')
            </div>

            <div class="flex flex-1 items-center justify-center py-10">
                <div class="grid w-full max-w-6xl items-center gap-10 lg:grid-cols-2">
                    <div class="hidden lg:block">
                        <div class="max-w-xl">
                            <span class="inline-flex rounded-full bg-indigo-100 px-4 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                                پلتفرم همراهی و حمایت
                            </span>

                            <h1 class="mt-6 text-4xl font-black leading-tight text-slate-900 dark:text-white">
                                بستری برای اتصال
                                <span class="text-indigo-600 dark:text-indigo-400">مادران</span>
                                و
                                <span class="text-rose-500 dark:text-rose-400">همیاران</span>
                            </h1>

                            <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-400">
                                در این سامانه می‌توانید با نقش خود وارد شوید، اطلاعات‌تان را تکمیل کنید و از مسیرهای همکاری، خدمات و ارتباطات محلی استفاده کنید.
                            </p>

                            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">مسیر ساده و روشن</div>
                                    <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">ورود و ثبت‌نام با تجربه‌ای قابل فهم و مرحله‌بندی‌شده.</div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">قابل توسعه برای آینده</div>
                                    <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">طراحی شده برای رشد تدریجی محصول بدون آشفتگی در تجربه کاربری.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
