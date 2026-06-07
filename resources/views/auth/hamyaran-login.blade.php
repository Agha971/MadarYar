@extends('layouts.auth')

@section('content')
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white">ورود همیاران</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                با شماره موبایل و رمز عبور وارد پنل همیاران شوید.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('hamyaran.login.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">شماره موبایل</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">رمز عبور</label>
                <input
                    type="password"
                    name="password"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                >
            </div>

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400"
            >
                ورود به پنل همیاران
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
            حساب ندارید؟
            <a href="/hamyaran/register" class="font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                ثبت‌نام همیاران
            </a>
        </div>
    </div>
@endsection
