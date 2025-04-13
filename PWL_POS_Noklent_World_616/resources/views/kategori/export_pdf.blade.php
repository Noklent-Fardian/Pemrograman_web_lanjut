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

    <div class="document-title">Laporan Data Kategori</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="10%">No</th>
                <th width="30%">Kode Kategori</th>
                <th width="60%">Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $k)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $k->kategori_kode }}</td>
                    <td>{{ $k->kategori_nama }}</td>
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