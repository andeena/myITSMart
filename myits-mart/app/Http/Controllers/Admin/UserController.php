<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,customer',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Tambahkan pengaman agar admin tidak bisa menghapus dirinya sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }
}