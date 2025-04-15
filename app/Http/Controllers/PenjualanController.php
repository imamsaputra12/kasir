<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pelanggan;
use App\Produk;
use PDF;
use DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with(['pelanggan', 'produk'])->orderBy('tanggal_penjualan', 'desc')->get();
        return view('penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualans.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'nullable|exists:pelanggans,pelanggan_id',
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'exists:produks,produk_id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,credit_card,e_wallet',
            'status' => 'required|in:paid,pending,failed',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        DB::beginTransaction();
        try {
            $totalBayar = 0;
            $produkTerpilih = [];
    
            foreach ($request->produk_id as $key => $produk_id) {
                $produk = Produk::findOrFail($produk_id);
                $jumlah = $request->jumlah[$key];
    
                if ($produk->stok < $jumlah) {
                    return redirect()->back()->with('error', "Stok produk {$produk->nama_produk} tidak mencukupi")->withInput();
                }
    
                $produk->stok -= $jumlah;
                $produk->save();
    
                $subtotal = $produk->harga * $jumlah;
                $totalBayar += $subtotal;
    
                $produkTerpilih[] = [
                    'produk_id' => $produk->produk_id,
                    'nama_produk' => $produk->nama_produk,
                    'jumlah' => $jumlah,
                    'harga' => $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }
    
            if ($request->jumlah_bayar < $totalBayar && $request->status == 'lunas') {
                return redirect()->back()->with('error', "Status tidak boleh 'lunas' jika jumlah bayar kurang dari total.")->withInput();
            }
    
            $penjualan = Penjualan::create([
                'pelanggan_id' => $request->pelanggan_id,
                'produk_id' => json_encode($produkTerpilih),
                'kode_pembayaran' => $this->generateKodePembayaran(),
                'tanggal_penjualan' => Carbon::now(),
                'total_bayar' => $totalBayar,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->jumlah_bayar - $totalBayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->status,
            ]);
    
            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Transaksi berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }    
    

    public function edit($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
        }

        $pelanggans = Pelanggan::all();
        $produks = Produk::all();

        return view('penjualans.edit', compact('penjualan', 'pelanggans', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'nullable|exists:pelanggans,pelanggan_id',
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'exists:produks,produk_id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,credit_card,e_wallet',
            'status' => 'required|in:paid,pending,failed',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($id);
    
            // Kembalikan stok produk sebelumnya
            $produkLama = json_decode($penjualan->produk_id, true);
            foreach ($produkLama as $item) {
                $produk = Produk::find($item['produk_id']);
                if ($produk) {
                    $produk->stok += $item['jumlah']; // kembalikan stok
                    $produk->save();
                }
            }
    
            $totalBayar = 0;
            $produkTerpilih = [];
    
            foreach ($request->produk_id as $key => $produk_id) {
                $produk = Produk::findOrFail($produk_id);
                $jumlah = $request->jumlah[$key];
    
                if ($produk->stok < $jumlah) {
                    return redirect()->back()->with('error', "Stok produk {$produk->nama_produk} tidak mencukupi")->withInput();
                }
    
                $produk->stok -= $jumlah;
                $produk->save();
    
                $subtotal = $produk->harga * $jumlah;
                $totalBayar += $subtotal;
    
                $produkTerpilih[] = [
                    'produk_id' => $produk->produk_id,
                    'nama_produk' => $produk->nama_produk,
                    'jumlah' => $jumlah,
                    'harga' => $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }
    
            if ($request->jumlah_bayar < $totalBayar && $request->status == 'lunas') {
                return redirect()->back()->with('error', "Status tidak boleh 'lunas' jika jumlah bayar kurang dari total.")->withInput();
            }
    
            $penjualan->update([
                'pelanggan_id' => $request->pelanggan_id,
                'produk_id' => json_encode($produkTerpilih),
                'total_bayar' => $totalBayar,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->jumlah_bayar - $totalBayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->status,
            ]);
    
            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }    

    public function generateKodePembayaran()
    {
        return 'PAY-' . strtoupper(uniqid());
    }

    public function destroy($id)
{
    $penjualan = Penjualan::find($id);
    if (!$penjualan) {
        return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
    }

    DB::beginTransaction();
    try {
        // Kembalikan stok produk sebelum menghapus transaksi
        $produkLama = json_decode($penjualan->produk_id, true);
        if ($produkLama) {
            foreach ($produkLama as $item) {
                $produk = Produk::find($item['produk_id']);
                if ($produk) {
                    $produk->stok += $item['jumlah'];
                    $produk->save();
                }
            }
        }

        // Hapus transaksi
        $penjualan->delete();

        DB::commit();
        return redirect()->route('penjualans.index')->with('success', 'Transaksi berhasil dihapus');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function show($id)
{
    $penjualan = Penjualan::with('pelanggan')->find($id);
    if (!$penjualan) {
        return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
    }

    // Decode data produk yang disimpan dalam format JSON
    $produkList = json_decode($penjualan->produk_id, true);

    return view('penjualans.show', compact('penjualan', 'produkList'));
}

public function laporan(Request $request)
{
    date_default_timezone_set('Asia/Jakarta');

    $periode = $request->get('periode', 'semua');
    $tanggalAwalInput = $request->get('tanggal_awal');
    $tanggalAkhirInput = $request->get('tanggal_akhir');
    
    $today = Carbon::now()->toDateString();
    $query = Penjualan::query();
    
    $tanggalAwal = null;
    $tanggalAkhir = null;
    
    // 1. Filter berdasarkan input tanggal manual
    if ($tanggalAwalInput && $tanggalAkhirInput) {
        $tanggalAwal = Carbon::parse($tanggalAwalInput)->toDateString();
        $tanggalAkhir = Carbon::parse($tanggalAkhirInput)->toDateString();
    
        $query->whereBetween('tanggal_penjualan', [$tanggalAwal, $tanggalAkhir]);
    }
    
    // 2. Kalau tidak ada input manual, cek periode
    else {
        if ($periode == 'hari') {
            $tanggalAwal = $tanggalAkhir = $today;
    
            $query->whereDate('tanggal_penjualan', $today);
        } elseif ($periode == 'minggu') {
            $tanggalAwal = Carbon::now()->startOfWeek()->toDateString();
            $tanggalAkhir = Carbon::now()->endOfWeek()->toDateString();
    
            $query->whereBetween('tanggal_penjualan', [$tanggalAwal, $tanggalAkhir])
                  ->whereDate('tanggal_penjualan', '!=', $today);
        } elseif ($periode == 'bulan') {
            $tanggalAwal = Carbon::now()->startOfMonth()->toDateString();
            $tanggalAkhir = Carbon::now()->endOfMonth()->toDateString();
    
            $query->whereMonth('tanggal_penjualan', Carbon::now()->month)
                  ->whereYear('tanggal_penjualan', Carbon::now()->year)
                  ->whereDate('tanggal_penjualan', '!=', $today);
        } elseif ($periode == 'tahun') {
            $tanggalAwal = Carbon::now()->startOfYear()->toDateString();
            $tanggalAkhir = Carbon::now()->endOfYear()->toDateString();
    
            $query->whereYear('tanggal_penjualan', Carbon::now()->year)
                  ->whereDate('tanggal_penjualan', '!=', $today);
        }
    }
    
    $penjualans = $query->orderBy('tanggal_penjualan', 'desc')->get();
    


    // Pastikan tidak menampilkan data kosong
    if ($penjualans->isEmpty()) {
        $penjualans = collect([
            (object) [
                'kode_pembayaran' => '-',
                'tanggal_penjualan' => '-',
                'pelanggan' => (object) ['nama_pelanggan' => '-'],
                'produk_id' => '[]',
                'total_bayar' => 0,
                'metode_pembayaran' => '-',
                'status' => '-',
            ]
        ]);
    }

    // Hitung statistik
// Hitung statistik
    $totalPenjualan = $penjualans->where('status', 'paid')->sum('total_bayar');
    $transaksiSukses = $penjualans->where('status', 'paid')->count();
    $transaksiGagal = $penjualans->where('status', 'unpaid')->count();

    return view('laporans.index', compact('penjualans', 'totalPenjualan', 'transaksiSukses', 'transaksiGagal','periode','tanggalAwal','tanggalAkhir'));
}

}