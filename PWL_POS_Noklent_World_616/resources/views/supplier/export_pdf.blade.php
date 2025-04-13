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

    <div class="document-title">Laporan Data Supplier</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="10%">Kode</th>
                <th width="20%">Nama Supplier</th>
                <th width="25%">Alamat</th>
                <th width="13%">Kontak</th>
                <th width="17%">Email</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $s)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $s->supplier_kode }}</td>
                    <td>{{ $s->name_supplier }}</td>
                    <td>{{ $s->supplier_alamat }}</td>
                    <td>{{ $s->supplier_contact }}</td>
                    <td>{{ $s->supplier_email }}</td>
                    <td class="text-center">{{ $s->supplier_aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
                </tr>
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