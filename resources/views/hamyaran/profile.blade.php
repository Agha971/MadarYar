@extends('layouts.hamyar')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6 space-y-6">

    @if(session('success'))
        <div class="p-3 rounded-xl bg-green-50 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-3 rounded-xl bg-red-50 text-red-800 border border-red-200">
            <ul class="list-disc pr-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('hamyaran.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- کارت عکس --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5">
            <h2 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">عکس پروفایل</h2>

            <div class="flex items-center gap-4">
                @php
                    $photoUrl = $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : null;
                @endphp

                <div class="w-16 h-16 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center">
                    @if($photoUrl)
                        <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="profile photo">
                    @else
                        <span class="text-slate-400 text-xs">بدون عکس</span>
                    @endif
                </div>

                <div class="flex-1">
                    <input type="file" name="profile_photo" accept="image/*"
                           class="block w-full text-sm
                           file:mr-2 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-slate-700
                           dark:file:bg-slate-800 dark:file:text-slate-200
                           text-slate-700 dark:text-slate-200">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">حداکثر ۲ مگابایت (JPG/PNG/WebP)</p>
                </div>
            </div>
        </div>

        {{-- اطلاعات حساب --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5">
            <h2 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">اطلاعات حساب</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">نام</label>
                    <input name="name" value="{{ old('name', $user->name) }}"
                           class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">موبایل</label>
                    <input name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">ایمیل (اختیاری)</label>
                    <input name="email" value="{{ old('email', $user->email) }}"
                           class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        {{-- محدوده فعالیت: منطقه/محله --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5">
            <h2 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">محدوده فعالیت</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">منطقه</label>
                    <select id="region_id" name="region_id"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">انتخاب کنید</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}"
                                @selected((string)old('region_id', $selectedRegionId) === (string)$r->id)>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">محله</label>
                    <select id="neighborhood_id" name="neighborhood_id"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">ابتدا منطقه را انتخاب کنید</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- همکاری و معرفی --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5">
            <h2 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">اطلاعات همکاری</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">نوع همکاری</label>
                    @php $ct = old('cooperation_type', $profile->cooperation_type); @endphp
                    <select name="cooperation_type"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">انتخاب کنید</option>
                        <option value="hamyar"   @selected($ct==='hamyar')>همیار محله</option>
                        <option value="mosque"  @selected($ct==='mosque')>مسجد</option>
                        <option value="sara"    @selected($ct==='sara')>سرای محله</option>
                        <option value="support" @selected($ct==='support')>پشتیبان</option>
                        <option value="sponsor" @selected($ct==='sponsor')>حامی</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">نام مجموعه/سازمان (اختیاری)</label>
                    <input name="organization_name" value="{{ old('organization_name', $profile->organization_name) }}"
                           class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">عنوان مسئولیت (اختیاری)</label>
                    <input name="position_title" value="{{ old('position_title', $profile->position_title) }}"
                           class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">مهارت‌ها/سابقه کوتاه (اختیاری)</label>
                    <textarea name="skills_text" rows="3"
                              class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">{{ old('skills_text', $profile->skills_text) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm mb-2 text-slate-700 dark:text-slate-300">توضیح کوتاه (اختیاری)</label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $profile->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">
                ذخیره پروفایل
            </button>
        </div>
    </form>
</div>

{{-- JS فیلتر منطقه -> محله --}}
<script>
    const neighborhoods = @json($neighborhoods);
    const regionSelect = document.getElementById('region_id');
    const neighborhoodSelect = document.getElementById('neighborhood_id');

    function fillNeighborhoods(regionId, selectedNeighborhoodId = null) {
        neighborhoodSelect.innerHTML = '';

        if (!regionId) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'ابتدا منطقه را انتخاب کنید';
            neighborhoodSelect.appendChild(opt);
            return;
        }

        const items = neighborhoods.filter(n => String(n.parent_id) === String(regionId));

        const opt0 = document.createElement('option');
        opt0.value = '';
        opt0.textContent = 'انتخاب کنید';
        neighborhoodSelect.appendChild(opt0);

        items.forEach(n => {
            const opt = document.createElement('option');
            opt.value = n.id;
            opt.textContent = n.name;
            if (selectedNeighborhoodId && String(selectedNeighborhoodId) === String(n.id)) {
                opt.selected = true;
            }
            neighborhoodSelect.appendChild(opt);
        });
    }

    // initial
    const initialRegionId = "{{ old('region_id', $selectedRegionId) }}";
    const initialNeighborhoodId = "{{ old('neighborhood_id', $user->neighborhood_id) }}";
    fillNeighborhoods(initialRegionId, initialNeighborhoodId);

    regionSelect.addEventListener('change', function () {
        fillNeighborhoods(this.value, null);
    });
</script>
@endsection
