<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12pt;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .store-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .store-address {
            font-size: 10pt;
            margin-bottom: 2px;
        }
        
        .receipt-title {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
        }
        
        .transaction-info {
            margin: 15px 0;
        }
        
        .transaction-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .transaction-info th {
            text-align: left;
            width: 130px;
        }
        
        .transaction-info td, .transaction-info th {
            padding: 3px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .items-table thead {
            border-bottom: 1px solid #000;
        }
        
        .items-table th {
            text-align: left;
            padding: 5px 0;
        }
        
        .items-table td {
            padding: 5px 0;
        }
        
        .items-table .right {
            text-align: right;
        }
        
        .items-table .center {
            text-align: center;
        }
        
        .total-section {
            border-top: 1px solid #000;
            margin-top: 10px;
            padding-top: 10px;
        }
        
        .total-row {
            font-weight: bold;
            font-size: 14pt;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10pt;
        }
        
        .thank-you {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="store-name">PWL POS Nokurento</div>
        <div class="store-address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
        <div class="store-address">Telp. (0341) 404424</div>
        
        <div class="receipt-title">BUKTI PEMBAYARAN</div>
    </div>
    
    <div class="transaction-info">
        <table>
            <tr>
                <th>No. Transaksi</th>
                <td>: {{ $penjualan->penjualan_kode }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>: {{ date('d-m-Y H:i', strtotime($penjualan->created_at)) }}</td>
            </tr>
            <tr>
                <th>Kasir</th>
                <td>: {{ $penjualan->user->nama }}</td>
            </tr>
            <tr>
                <th>Pembeli</th>
                <td>: {{ $penjualan->pembeli }}</td>
            </tr>
        </table>
    </div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Item</th>
                <th width="15%" class="right">Harga</th>
                <th width="15%" class="center">Qty</th>
                <th width="20%" class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->barang->barang_nama }}</td>
                <td class="right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td class="center">{{ $detail->jumlah }}</td>
                <td class="right">{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total-section">
        <table class="items-table">
            <tr class="total-row">
                <td colspan="4" class="right">TOTAL</td>
                <td class="right">
                    Rp {{ number_format($penjualan->details->sum(function($detail) {
                        return $detail->jumlah * $detail->harga;
                    }), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        <div class="thank-you">-- Terima Kasih Atas Kunjungan Anda --</div>
        <div>Barang yang sudah dibeli tidak dapat dikembalikan.</div>
        <div>Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}</div>
    </div>
</body>
</html>