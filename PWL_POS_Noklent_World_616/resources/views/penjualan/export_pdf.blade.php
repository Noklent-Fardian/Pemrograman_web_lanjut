<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/export_pdf.css') }}">
</head>

<body>
    <table class="letterhead">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('img/polinema-bw.png') }}" alt="Logo" class="logo" />
            </td>
            <td width="70%" class="text-center">
                <div class="ministry">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                <div class="institution">POLITEKNIK NEGERI MALANG</div>
                <div class="address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div class="address">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
                <div class="address">Laman: www.polinema.ac.id</div>
            </td>
            <td width="15%" class="text-center">
                <img src="{{ public_path('img/logo_clean.png') }}" alt="Logo" class="logo" />
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Penjualan</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Pembeli</th>
                <th width="18%">Petugas</th>
                <th class="text-right" width="15%">Jumlah Item</th>
                <th class="text-right" width="15%">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualans as $index => $penjualan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $penjualan->penjualan_kode }}</td>
                    <td>{{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}</td>
                    <td>{{ $penjualan->pembeli }}</td>
                    <td>{{ $penjualan->user->nama }}</td>
                    <td class="text-right">{{ $penjualan->details->count() }}</td>
                    <td class="text-right">
                        {{ number_format($penjualan->details->sum(function($detail) { 
                            return $detail->jumlah_barang * $detail->harga_barang; 
                        }), 0, ',', '.') }}
                    </td>
                </tr>sa
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}
    </div>
    
    <div class="page-number">
        Halaman 1
    </div>
    
    <div class="watermark">
        PWL POS - Nokurento
    </div>
</body>
</html>