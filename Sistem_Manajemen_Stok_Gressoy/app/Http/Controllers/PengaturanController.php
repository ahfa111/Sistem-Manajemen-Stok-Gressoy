<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Data Pengaturan User',
                'data' => $user
            ]);
        }

        $all_users = \App\Models\User::all();
        return view('pengaturan.index', compact('user', 'all_users'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'job_title' => $request->job_title,
        ]);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => $user
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'business_type' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_email' => $request->company_email,
            'business_type' => $request->business_type,
        ]);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Info Perusahaan berhasil diperbarui',
                'data' => $user
            ]);
        }

        return back()->with('success', 'Info Perusahaan berhasil diperbarui.');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'notify_low_stock' => $request->has('notify_low_stock'),
            'notify_stock_in' => $request->has('notify_stock_in'),
            'notify_transaction' => $request->has('notify_transaction'),
            'notify_expiry' => $request->has('notify_expiry'),
            'notify_daily_report' => $request->has('notify_daily_report'),
            'notify_email' => $request->has('notify_email'),
        ]);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan notifikasi berhasil disimpan',
                'data' => $user
            ]);
        }

        return back()->with('success', 'Pengaturan notifikasi berhasil disimpan.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'new_password.min' => 'Password minimal harus 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);
        }

        return back()->with('success', 'Password berhasil diubah.');
    }
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Akun Anda berhasil dihapus'
            ]);
        }

        return redirect('/login')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
