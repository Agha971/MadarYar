<header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-900/90">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="/" class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-lg font-bold text-white shadow-sm">
                ه
            </div>
            <div>
                <div class="text-base font-extrabold text-slate-900 dark:text-white">همیار مادر</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">سامانه حمایت، همراهی و شبکه‌سازی</div>
            </div>
        </a>

        <nav class="hidden items-center gap-6 md:flex">
            <a href="/" class="text-sm font-medium text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">خانه</a>
            <a href="#" class="text-sm font-medium text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">درباره سامانه</a>
            <a href="/hamyaran/register" class="text-sm font-medium text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">همیار مادر شوید</a>
        </nav>

        <div class="flex items-center gap-3">
            @include('components.theme-toggle')

            <a href="/login" class="hidden rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 sm:inline-flex">
                ورود مادر
            </a>

            <a href="/hamyaran/login" class="inline-flex rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                ورود همیاران
            </a>
        </div>
    </div>
</header>
