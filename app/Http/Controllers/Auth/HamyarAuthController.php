<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\HamyarProfile;
use App\Models\Neighborhood;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class HamyarAuthController extends Controller
{
    public function showRegister()
    {
        $regions = Neighborhood::whereNull('parent_id')->orderBy('name')->get();
        $neighborhoods = Neighborhood::whereNotNull('parent_id')->orderBy('name')->get();

        return view('auth.hamyaran-register', compact('regions', 'neighborhoods'));
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],

            'cooperation_type' => ['required', 'string', 'max:50'],
            'neighborhood_id' => ['nullable', 'exists:neighborhoods,id'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'position_title' => ['nullable', 'string', 'max:255'],
            'experience_text' => ['nullable', 'string'],
            'skills_text' => ['nullable', 'string'],
            'availability_text' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'neighborhood_id' => $request->neighborhood_id,
            'status' => 'pending',
            'is_active' => true,
            'profile_completed' => true,
        ]);

        $user->assignRole('hamyar');

        HamyarProfile::create([
            'user_id' => $user->id,
            'cooperation_type' => $request->cooperation_type,
            'neighborhood_id' => $request->neighborhood_id,
            'organization_name' => $request->organization_name,
            'position_title' => $request->position_title,
            'experience_text' => $request->experience_text,
            'skills_text' => $request->skills_text,
            'availability_text' => $request->availability_text,
            'description' => $request->description,
        ]);

        Auth::login($user);

        return redirect()->route('hamyaran.pending')
            ->with('success', 'ثبت‌نام شما انجام شد و درخواست شما در انتظار بررسی است.');
    }

    public function showLogin()
    {
        return view('auth.hamyaran-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('phone', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'phone' => 'شماره موبایل یا رمز عبور صحیح نیست.',
            ])->onlyInput('phone');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user->hasRole('hamyar')) {
            Auth::logout();

            return redirect()->route('hamyaran.login')
                ->withErrors(['phone' => 'این بخش مخصوص همیاران است.']);
        }

        if ($user->status !== 'approved') {
            return redirect()->route('hamyaran.pending');
        }

        return redirect()->route('hamyaran.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (! $user->hasRole('hamyar')) {
            abort(403);
        }

        if ($user->status === 'pending') {
            return redirect()->route('hamyaran.pending');
        }

        return view('hamyaran.dashboard', compact('user'));
    }


    public function pending()
    {
        $user = Auth::user();

        if (! $user || ! $user->hasRole('hamyar')) {
            abort(403);
        }

        if ($user->status === 'approved') {
            return redirect()->route('hamyaran.dashboard');
        }

        return view('hamyaran.pending');
    }

    public function showProfile(Request $request)
    {
        $user = $request->user();

        $profile = $user->hamyarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        // مناطق = ریشه‌ها
        $regions = Neighborhood::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        // همه محله‌ها (برای JS) یا می‌تونی فقط childrenها رو بگیری
        $neighborhoods = Neighborhood::query()
            ->whereNotNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name', 'parent_id']);

        // اگر قبلاً محله انتخاب شده، region را از parent_id درمیاریم
        $selectedRegionId = null;
        if ($user->neighborhood_id) {
            $selectedNeighborhood = Neighborhood::find($user->neighborhood_id);
            $selectedRegionId = $selectedNeighborhood?->parent_id;
        }

        return view('hamyaran.profile', compact(
            'user',
            'profile',
            'regions',
            'neighborhoods',
            'selectedRegionId'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $profile = $user->hamyarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $validated = $request->validate([
            // users
            'name' => ['required', 'string', 'max:190'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:190'],

            // UI فقط برای فیلتر است (ذخیره نمی‌کنیم)
            'region_id' => ['nullable', 'integer', 'exists:neighborhoods,id'],

            // محله نهایی باید child باشد
            'neighborhood_id' => ['nullable', 'integer', 'exists:neighborhoods,id'],

            // profile v1 slim
            'cooperation_type' => ['nullable', 'string', 'max:50'],
            'organization_name' => ['nullable', 'string', 'max:190'],
            'position_title' => ['nullable', 'string', 'max:190'],
            'skills_text' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:2000'],

            // photo
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $neighborhoodId = $validated['neighborhood_id'] ?? null;

        if ($neighborhoodId) {
            $n = Neighborhood::find($neighborhoodId);
            if (!$n || $n->parent_id === null) {
                return back()
                    ->withErrors(['neighborhood_id' => 'محله انتخاب‌شده معتبر نیست.'])
                    ->withInput();
            }
        }

        // آپلود عکس
        if ($request->hasFile('profile_photo')) {

            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->email = $validated['email'] ?? null;
        $user->neighborhood_id = $neighborhoodId;

        // بررسی تغییرات مهم
        $importantChanged = false;

        // تغییر محله
        if ($user->neighborhood_id != $neighborhoodId) {
            $importantChanged = true;
        }

        // تغییر نوع همکاری
        if ($profile->cooperation_type != ($validated['cooperation_type'] ?? null)) {
            $importantChanged = true;
        }

        // اگر اولین بار است
        if (!$user->profile_completed) {
            $user->profile_completed = true;
            $user->status = 'pending';
        }
        // اگر قبلاً تایید شده و تغییر مهم داشته
        elseif ($user->status === 'approved' && $importantChanged) {
            $user->status = 'pending';
        }


        $user->save();

        $profile->update([
            'cooperation_type' => $validated['cooperation_type'] ?? null,
            'organization_name' => $validated['organization_name'] ?? null,
            'position_title' => $validated['position_title'] ?? null,
            'skills_text' => $validated['skills_text'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('hamyaran.pending');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('hamyaran.login');
    }
}
