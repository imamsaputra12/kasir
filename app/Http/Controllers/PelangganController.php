<?php

namespace App\Http\Controllers;

use App\Pelanggan; // Pastikan model ada di folder App\Models
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    // Menampilkan daftar semua pelanggan
    public function index()
    {
        $pelanggans = Pelanggan::all(); 
        return view('pelanggans.index', compact('pelanggans')); 
    }

    // Menampilkan form untuk menambah pelanggan baru
    public function create()
    {
        return view('pelanggans.create'); 
    }

    // Menyimpan pelanggan baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function show($id)
{
    $pelanggan = Pelanggan::findOrFail($id);
    return view('pelanggans.show', compact('pelanggan'));
}


    // Menampilkan form untuk mengedit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return redirect()->route('pelanggans.index')->with('error', 'Pelanggan tidak ditemukan.');
        }
        return view('pelanggans.edit', compact('pelanggan'));
    }

    // Memperbarui data pelanggan
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return redirect()->route('pelanggans.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $pelanggan->update($request->all());

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    // Menghapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return redirect()->route('pelanggans.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $pelanggan->delete();

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}