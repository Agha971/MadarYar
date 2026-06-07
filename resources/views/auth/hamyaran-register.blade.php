<!DOCTYPE html>
<html lang="fa" dir="rtl" class="transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت‌نام همیاران</title>

    <script>
        (function () {
            const storedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (storedTheme === 'dark' || (!storedTheme && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">

    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="flex justify-end mb-4">
            <button
                id="theme-toggle"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700"
            >
                <span id="theme-icon">🌙</span>
                <span id="theme-text">حالت تیره</span>
            </button>
        </div>

        <div class="grid lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6 dark:bg-slate-900 dark:border-slate-800">
                    <h1 class="text-2xl font-bold mb-3 text-slate-900 dark:text-white">ثبت‌نام همیاران</h1>
                    <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">
                        اگر به عنوان همیار محله، مسجد، سرای محله، حامی یا پشتیبان قصد همکاری دارید،
                        فرم زیر را تکمیل کنید. پس از بررسی توسط ادمین، دسترسی شما فعال می‌شود.
                    </p>

                    <div class="mt-6 space-y-3 text-sm text-slate-700 dark:text-slate-300">
                        <div class="flex items-start gap-2">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            <p>ثبت‌نام اولیه سریع و ساده</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            <p>انتخاب منطقه و محله</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            <p>بررسی و تأیید توسط مدیر سامانه</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('hamyaran.login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                            قبلاً ثبت‌نام کرده‌اید؟ ورود همیاران
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 dark:bg-slate-900 dark:border-slate-800">
                    <h2 class="text-xl font-bold mb-6 text-slate-900 dark:text-white">فرم اطلاعات همیار</h2>

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-900/40 dark:bg-red-950/40 dark:text-red-300">
                            <p class="font-semibold mb-2">لطفاً موارد زیر را بررسی کنید:</p>
                            <ul class="list-disc pr-5 space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('hamyaran.register.submit') }}" class="space-y-8">
                        @csrf

                        <div>
                            <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">اطلاعات حساب</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">نام و نام خانوادگی</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">شماره موبایل</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">ایمیل (اختیاری)</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">نوع همکاری</label>
                                    <select name="cooperation_type"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                        <option value="">انتخاب کنید</option>
                                        <option value="hamyar" {{ old('cooperation_type') == 'hamyar' ? 'selected' : '' }}>همیار محله</option>
                                        <option value="mosque" {{ old('cooperation_type') == 'mosque' ? 'selected' : '' }}>مسجد</option>
                                        <option value="sara" {{ old('cooperation_type') == 'sara' ? 'selected' : '' }}>سرای محله</option>
                                        <option value="support" {{ old('cooperation_type') == 'support' ? 'selected' : '' }}>پشتیبان</option>
                                        <option value="sponsor" {{ old('cooperation_type') == 'sponsor' ? 'selected' : '' }}>حامی</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">رمز عبور</label>
                                    <input type="password" name="password"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">تکرار رمز عبور</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 dark:border-slate-700 pt-8">
                            <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">محدوده فعالیت</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">منطقه</label>
                                    <select name="region_id" id="region_id"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                        <option value="">ابتدا منطقه را انتخاب کنید</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">محله</label>
                                    <select name="neighborhood_id" id="neighborhood_id"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                        <option value="">ابتدا منطقه را انتخاب کنید</option>
                                        @foreach ($neighborhoods as $neighborhood)
                                            <option value="{{ $neighborhood->id }}"
                                                    data-parent="{{ $neighborhood->parent_id }}"
                                                    {{ old('neighborhood_id') == $neighborhood->id ? 'selected' : '' }}>
                                                {{ $neighborhood->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 dark:border-slate-700 pt-8">
                            <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">اطلاعات تکمیلی</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">نام سازمان / مجموعه</label>
                                    <input type="text" name="organization_name" value="{{ old('organization_name') }}"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">عنوان مسئولیت</label>
                                    <input type="text" name="position_title" value="{{ old('position_title') }}"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">سابقه / تجربه</label>
                                    <textarea name="experience_text" rows="4"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('experience_text') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">مهارت‌ها</label>
                                    <textarea name="skills_text" rows="4"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('skills_text') }}</textarea>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">زمان‌های همکاری</label>
                                    <textarea name="availability_text" rows="4"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('availability_text') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">توضیحات</label>
                                    <textarea name="description" rows="4"
                                        class="w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 dark:border-slate-700 pt-6 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                با ثبت این فرم، درخواست شما برای بررسی ارسال می‌شود.
                            </p>

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-white font-medium hover:bg-indigo-700 transition">
                                ارسال فرم ثبت‌نام
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const regionSelect = document.getElementById('region_id');
        const neighborhoodSelect = document.getElementById('neighborhood_id');

        function filterNeighborhoods() {
            const selectedRegion = regionSelect.value;
            const options = neighborhoodSelect.querySelectorAll('option');
            const oldValue = neighborhoodSelect.value;

            options.forEach(option => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                const parentId = option.getAttribute('data-parent');
                option.hidden = parentId !== selectedRegion;
            });

            const selectedOption = neighborhoodSelect.querySelector(`option[value="${oldValue}"]`);
            if (!selectedOption || selectedOption.hidden) {
                neighborhoodSelect.value = '';
            }
        }

        regionSelect.addEventListener('change', filterNeighborhoods);
        window.addEventListener('load', filterNeighborhoods);
    </script>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const themeText = document.getElementById('theme-text');

        function updateThemeButton() {
            const isDark = document.documentElement.classList.contains('dark');
            themeIcon.textContent = isDark ? '☀️' : '🌙';
            themeText.textContent = isDark ? 'حالت روشن' : 'حالت تیره';
        }

        themeToggle.addEventListener('click', function () {
            const isDark = document.documentElement.classList.contains('dark');

            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }

            updateThemeButton();
        });

        updateThemeButton();
    </script>
</body>
</html>
