<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Poin Siswa - SIPESDA</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; margin: 0; padding: 20px; }
        .header { text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; }
        .header h2 { margin: 0; font-size: 14px; border-bottom: 2px solid #000; display: inline-block; padding-bottom: 5px; }
        
        .info-table { width: 100%; margin-bottom: 10px; border-collapse: collapse; }
        .info-table td { padding: 2px 0; vertical-align: top; }
        .info-label { width: 120px; }
        .info-separator { width: 10px; }

        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 4px; text-align: left; }
        .main-table th { background-color: #f0f0f0; text-align: center; text-transform: uppercase; }
        .text-center { text-align: center; }
        
        .summary-box { width: 100%; border: 1px solid #000; margin-top: -1px; padding: 5px; box-sizing: border-box; }
        .summary-row { display: flex; margin-bottom: 2px; }
        .summary-label { width: 120px; font-weight: bold; }

        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Madrasah Tsanawiyah Da'il Khairaat</h2>
        <p style="margin: 5px 0;">Jl. Peta Barat No 110 B Pegadungan Kalideres Jakarta Barat</p>
        <hr>
        <h3 style="margin-top: 10px;">DAFTAR POIN SISWA PERIODE {{ $periode ?? '2025/2026' }}</h3>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama</td>
            <td class="info-separator">:</td>
            <td><strong>{{ $siswa->nama }}</strong></td>
        </tr>
        <tr>
            <td class="info-label">NIS</td>
            <td class="info-separator">:</td>
            <td>{{ $siswa->nis }}</td>
        </tr>
        <tr>
            <td class="info-label">Kelas</td>
            <td class="info-separator">:</td>
            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Jenis Kelamin</td>
            <td class="info-separator">:</td>
            <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="info-label">Nama Orang Tua</td>
            <td class="info-separator">:</td>
            <td>{{ $siswa->nama_wali }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="8%">Tingkat Pelanggaran</th>
                <th width="62%">Jenis Pelanggaran</th>
                <th width="15%">Skor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa->pelanggaran as $p)
                <tr>
                    <td class="text-center">{{ date('d-M-yy', strtotime($p->tanggal)) }}</td>
                    <td class="text-center">{{ $p->jenisPelanggaran->tingkatPelanggaran->tingkat ?? '-' }}</td>
                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                    <td class="text-center">{{ $p->jenisPelanggaran->tingkatPelanggaran->nilai ?? 0 }}</td>
                </tr>
            @empty
                @for($i = 0; $i < 10; $i++)
                <tr>
                    <td style="color: transparent;">-</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
            @endforelse
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-row">
            <div class="summary-label">Jumlah Poin</div>
            <div>: {{ $siswa->total_poin ?? 0 }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Tindakan Disiplin</div>
            <div>: {{ $siswa->tindakan_disiplin->tahap->deskripsi?? 'Peringatan Lisan' }}</div>
        </div>
    </div>
</body>
</html>