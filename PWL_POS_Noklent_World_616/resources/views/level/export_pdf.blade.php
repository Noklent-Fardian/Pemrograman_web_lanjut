<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/export_pdf.css') }}">
</head>

<body>
    <!-- Header/Letterhead -->
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

    <!-- Document Title -->
    <div class="document-title">Laporan Data Level User</div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="10%">No</th>
                <th width="30%">Kode Level</th>
                <th width="60%">Nama Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($level as $l)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $l->level_kode }}</td>
                    <td>{{ $l->level_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Footer -->
    <div class="footer">
        Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}
    </div>
    
    <!-- Page number -->
    <div class="page-number">
        Halaman 1
    </div>
    
    <!-- Watermark -->
    <div class="watermark">
        PWL POS - Nokurento
    </div>
</body>
</html>