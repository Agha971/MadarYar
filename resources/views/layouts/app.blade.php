<!DOCTYPE html>
<html lang="fa" dir="rtl" x-data="{ dark: false }" x-init="
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        dark = true;
        document.documentElement.classList.add('dark');
    } else if (savedTheme === 'light') {
        dark = false;
        document.documentElement.classList.remove('dark');
    } else {
        dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', dark);
    }
" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'همیار مادر' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">
    @yield('body')
</body>
</html>
