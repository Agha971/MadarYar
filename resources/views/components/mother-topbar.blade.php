<header class="border-b border-slate-200 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-900/90">
    <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $pageTitle ?? 'پنل مادر' }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $pageDescription ?? 'مدیریت اطلاعات و پیگیری خدمات' }}</p>
        </div>

        <div class="flex items-center gap-3">
            @include('components.theme-toggle')

            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                {{ auth()->user()->name ?? 'کاربر' }}
            </div>
        </div>
    </div>
</header>
