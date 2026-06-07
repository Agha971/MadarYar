<button
    type="button"
    @click="
        dark = !dark;
        document.documentElement.classList.toggle('dark', dark);
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    "
    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
>
    <span x-show="!dark">🌙</span>
    <span x-show="dark">☀️</span>
    <span x-text="dark ? 'تم روشن' : 'تم تیره'"></span>
</button>
