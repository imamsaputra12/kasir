@extends('template')

@section('content')
<div class="container">
    <div id="struk" class="receipt">
        <div class="receipt-header">
            <div class="logo-area">
                <i class="fas fa-store"></i>
            </div>
            <h4>Struk Pembelian</h4>
            <div class="receipt-divider-dotted"></div>
        </div>
        
        <div class="receipt-info">
            <div class="info-item">
                <span class="info-label"><i class="fas fa-hashtag"></i> Kode Pembayaran:</span>
                <span class="info-value">{{ $penjualan->kode_pembayaran }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="far fa-calendar-alt"></i> Tanggal Pembayaran:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d-m-Y H:i:s') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="far fa-user"></i> Nama Pelanggan:</span>
                <span class="info-value">{{ $penjualan->pelanggan->nama_pelanggan ?? 'Umum' }}</span>
            </div>
        </div>
        
        <div class="receipt-divider"></div>
        
        <div class="receipt-items">
            <h5><i class="fas fa-shopping-cart"></i> Detail Produk</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $produkList = json_decode($penjualan->produk_id, true);
                    @endphp
                    @if($produkList)
                        @foreach($produkList as $produk)
                            <tr>
                                <td>{{ $produk['nama_produk'] }}</td>
                                <td>{{ $produk['jumlah'] }}</td>
                                <td>Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($produk['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="receipt-divider-dotted"></div>
        
        <div class="receipt-total">
            <div class="total-item">
                <span>Total Bayar:</span>
                <span>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-item">
                <span>Jumlah Bayar:</span>
                <span>Rp {{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-item highlight">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
            </div>
            <div class="payment-method">
                <span><i class="fas fa-credit-card"></i> Metode Pembayaran:</span>
                <span class="payment-badge">{{ ucfirst($penjualan->metode_pembayaran) }}</span>
            </div>
            <div class="payment-status">
                <span><i class="fas fa-check-circle"></i> Status:</span>
                @if($penjualan->status == 'paid')
                    <span class="status-badge status-success">Lunas</span>
                @elseif($penjualan->status == 'pending')
                    <span class="status-badge status-warning">Menunggu</span>
                @else
                    <span class="status-badge status-danger">Gagal</span>
                @endif
            </div>
        </div>
        
        <div class="receipt-divider-dotted"></div>
        
        <div class="receipt-footer">
            <p>Terima kasih atas pembelian Anda!</p>
            <div class="footer-logo">Toko Utama Jaya</div>
            <div class="barcode">
                <i class="fas fa-barcode"></i>
                <span>{{ $penjualan->kode_pembayaran }}</span>
            </div>
            <div class="receipt-contact">
                <div><i class="fas fa-phone"></i> (021) 1234-5678</div>
                <div><i class="fas fa-map-marker-alt"></i> Jl. Maju Bersama No. 123</div>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <button onclick="printStruk()" class="btn-print">
            <i class="fas fa-print"></i> Print Struk
        </button>
        <button onclick="downloadPDF()" class="btn-download">
            <i class="fas fa-download"></i> Download PDF
        </button>
    </div>
</div>

<script>
function printStruk() {
    // Persiapkan iframe untuk mencetak struk dengan stylesheet yang sama
    var printFrame = document.createElement('iframe');
    printFrame.style.position = 'absolute';
    printFrame.style.top = '-9999px';
    printFrame.style.left = '-9999px';
    document.body.appendChild(printFrame);
    
    // Ambil semua stylesheet dari dokumen utama
    var stylesheets = document.querySelectorAll('link[rel="stylesheet"], style');
    var styleContent = '';
    
    // Salin stylesheet
    stylesheets.forEach(function(stylesheet) {
        if (stylesheet.tagName === 'LINK') {
            styleContent += '<link rel="stylesheet" href="' + stylesheet.href + '">';
        } else if (stylesheet.tagName === 'STYLE') {
            styleContent += '<style>' + stylesheet.innerHTML + '</style>';
        }
    });
    
    // Salin template struk
    var strukContent = document.getElementById('struk').outerHTML;
    
    // Buat dokumen lengkap untuk dicetak
    var printDocument = '<!DOCTYPE html><html><head>' +
                        '<meta charset="utf-8">' +
                        '<meta name="viewport" content="width=device-width, initial-scale=1">' +
                        styleContent +
                        '<style>' +
                        '@import url("https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap");' +
                        '@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css");' +
                        '@media print {' +
                        '  @page { size: 80mm auto; margin: 0; }' +
                        '  html, body { width: 80mm; margin: 0; padding: 0; }' +
                        '  .receipt { max-width: 100%; box-shadow: none; border-radius: 0; margin: 0; padding: 0; border: none; }' +
                        '  .receipt-header { padding: 15px 10px; }' +
                        '  .logo-area i { animation: none; }' +
                        '  .table { font-size: 12px; }' +
                        '  .receipt-info, .receipt-items, .receipt-total, .receipt-footer { padding: 15px 10px; }' +
                        '  .info-item, .total-item { margin-bottom: 8px; font-size: 12px; }' +
                        '  .total-item.highlight { font-size: 14px; }' +
                        '  .receipt-footer p { font-size: 12px; }' +
                        '  .footer-logo { font-size: 16px; }' +
                        '  .barcode { margin: 15px 0; }' +
                        '  .receipt-contact { font-size: 11px; }' +
                        '  .action-buttons { display: none; }' +
                        '}' +
                        '</style>' +
                        '</head><body>' +
                        '<div class="container" style="padding:0;margin:0;display:block;width:100%;">' +
                        strukContent +
                        '</div>' +
                        '</body></html>';
    
    // Tulis konten ke iframe
    var frameDoc = printFrame.contentWindow || printFrame.contentDocument.document || printFrame.contentDocument;
    frameDoc.document.open();
    frameDoc.document.write(printDocument);
    frameDoc.document.close();
    
    // Tunggu resource dimuat sebelum mencetak
    setTimeout(function() {
        try {
            frameDoc.focus();
            frameDoc.print();
        } catch (error) {
            console.error('Gagal mencetak:', error);
            alert('Gagal mencetak struk. Gunakan Chrome atau Firefox untuk pengalaman terbaik.');
        }
        
        // Hapus frame setelah mencetak
        setTimeout(function() {
            printFrame.remove();
        }, 1000);
    }, 1000);
}

function downloadPDF() {
    // Implementasi untuk mengunduh sebagai PDF
    // (Memerlukan library seperti html2pdf.js atau jsPDF)
    alert('Untuk mengimplementasikan fitur Download PDF, tambahkan library html2pdf.js atau jsPDF ke proyek Anda.');
}
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
    
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }
    
    .receipt {
        max-width: 380px;
        margin: 30px auto;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 0;
        background: white;
        font-family: 'Nunito', sans-serif;
        color: #333;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #eaeaea;
    }
    
    .receipt:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }
    
    .receipt-header {
        background: linear-gradient(135deg, #00b8d4 0%, #00838f 100%);
        color: white;
        padding: 25px 20px;
        text-align: center;
        position: relative;
    }
    
    .logo-area {
        margin-bottom: 15px;
    }
    
    .logo-area i {
        font-size: 32px;
        background: rgba(255, 255, 255, 0.15);
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
        }
    }
    
    .receipt-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 24px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }
    
    .receipt-divider {
        height: 2px;
        background: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.1), transparent);
        margin: 15px 0;
    }
    
    .receipt-divider-dotted {
        height: 1px;
        border-bottom: 2px dotted #ddd;
        margin: 15px 0;
    }
    
    .receipt-info {
        padding: 25px 20px;
        background: #f9fafc;
        border-bottom: 1px solid #eee;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        align-items: center;
    }
    
    .info-label {
        color: #6c757d;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .info-label i {
        margin-right: 8px;
        color: #00b8d4;
        font-size: 16px;
    }
    
    .info-value {
        font-weight: 600;
        background: #eef1f8;
        padding: 5px 10px;
        border-radius: 6px;
        min-width: 120px;
        text-align: right;
    }
    
    .receipt-items {
        padding: 25px 20px;
    }
    
    .receipt-items h5 {
        margin-top: 0;
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 18px;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .receipt-items h5 i {
        margin-right: 10px;
        color: #00b8d4;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .table th {
        border-bottom: 2px solid #dee2e6;
        padding: 10px 8px;
        text-align: left;
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        font-size: 12px;
    }
    
    .table td {
        padding: 12px 8px;
        border-bottom: 1px solid #eee;
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .receipt-total {
        background: #f9fafc;
        padding: 25px 20px;
        border-top: 1px solid #eee;
    }
    
    .total-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 15px;
        align-items: center;
    }
    
    .total-item.highlight {
        font-weight: 700;
        font-size: 18px;
        margin-top: 15px;
        margin-bottom: 20px;
        padding-top: 15px;
        border-top: 2px dashed #dee2e6;
        color: #00838f;
    }
    
    .payment-method, .payment-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        font-size: 14px;
    }
    
    .payment-method i, .payment-status i {
        margin-right: 8px;
        color: #00b8d4;
    }
    
    .payment-badge {
        background: #eef1f8;
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
    }
    
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .status-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .receipt-footer {
        text-align: center;
        padding: 25px 20px;
        background: white;
    }
    
    .receipt-footer p {
        margin: 0 0 15px;
        font-size: 15px;
        font-weight: 600;
    }
    
    .footer-logo {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 15px;
        color: #00b8d4;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .barcode {
        margin: 20px 0;
        font-size: 14px;
        color: #6c757d;
    }
    
    .barcode i {
        font-size: 42px;
        margin-bottom: 8px;
        display: block;
    }
    
    .receipt-contact {
        margin-top: 20px;
        font-size: 13px;
        color: #6c757d;
    }
    
    .receipt-contact div {
        margin-top: 5px;
    }
    
    .receipt-contact i {
        margin-right: 5px;
        color: #00b8d4;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin: 30px 0 50px;
    }
    
    .btn-print, .btn-download {
        background: linear-gradient(135deg, #00b8d4 0%, #00838f 100%);
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Nunito', sans-serif;
        font-size: 15px;
        box-shadow: 0 4px 15px rgba(0, 184, 212, 0.3);
        display: flex;
        align-items: center;
    }
    
    .btn-download {
        background: linear-gradient(135deg, #00bcd4 0%, #009688 100%);
    }
    
    .btn-print:hover, .btn-download:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 184, 212, 0.4);
    }
    
    .btn-print i, .btn-download i {
        margin-right: 10px;
        font-size: 16px;
    }
    
    /* Pengaturan khusus untuk tampilan cetak */
    @media print {
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        html, body {
            width: 80mm;
            margin: 0;
            padding: 0;
        }
        
        .container {
            display: block;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        
        .receipt {
            max-width: 100%;
            margin: 0;
            padding: 0;
            box-shadow: none;
            border: none;
            border-radius: 0;
        }
        
        .receipt:hover {
            box-shadow: none;
            transform: none;
        }
        
        .logo-area i {
            animation: none;
        }
        
        .action-buttons {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .receipt {
            max-width: 100%;
            margin: 15px;
        }
        .action-buttons {
            flex-direction: column;
            width: 100%;
            padding: 0 20px;
        }
        .btn-print, .btn-download {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection