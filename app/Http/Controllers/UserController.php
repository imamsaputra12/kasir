<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Kasir User',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail user.
     */
    public function show()
    {
        return view('account.show');  // Pastikan ada tampilan yang sesuai
    }

    /**
     * Tampilkan form edit user.
     */
    public function edit()
    {
        $user = Auth::user();  // Mendapatkan data pengguna yang sedang login
        return view('account.edit', compact('user'));  // Mengirim data pengguna ke tampilan edit
    }

    /**
     * Update data user.
     */
    public function update(Request $request)
{
    $user = Auth::user();  // Mendapatkan pengguna yang sedang login

    // Validasi data yang dikirim
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // Perbarui data pengguna
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];

    if ($request->filled('password')) {
        $user->password = bcrypt($validatedData['password']);
    }

    // Menyimpan perubahan ke database
    $user->save();  // Ini adalah baris yang menggunakan save()
    
    return redirect()->route('account.edit')->with('success', 'Akun berhasil diperbarui!');
}


    /**
     * Hapus user dari database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
