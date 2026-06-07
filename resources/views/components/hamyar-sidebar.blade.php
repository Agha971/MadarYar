<aside class="hidden w-72 shrink-0 border-l border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900 lg:flex lg:flex-col">
    <div class="border-b border-slate-200 px-6 py-6 dark:border-slate-800">
        <a href="/" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-600 text-lg font-bold text-white">
                ه
            </div>
            <div>
                <div class="font-extrabold text-slate-900 dark:text-white">پنل همیاران</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">همیار مادر</div>
            </div>
        </a>
    </div>

    <nav class="flex-1 space-y-2 px-4 py-6">
        <a href="/hamyaran/dashboard" class="flex items-center rounded-2xl bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
            داشبورد
        </a>

        <a href="{{ route('hamyaran.profile') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
            پروفایل همکاری
        </a>

        <a href="#" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
            درخواست‌ها
        </a>

        <a href="/hamyaran/pending" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
            وضعیت بررسی
        </a>
    </nav>

    <div class="border-t border-slate-200 px-4 py-4 dark:border-slate-800">
        <form method="POST" action="{{ route('hamyaran.logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">
                خروج از حساب
            </button>
        </form>
    </div>
</aside>
