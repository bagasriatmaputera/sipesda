<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .badge-red { color: white; background-color: #dc2626; padding: 2px 5px; border-radius: 3px; }
        .badge-green { color: white; background-color: #16a34a; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SISTEM INFORMASI PELANGGARAN SISWA (SIPESDA)</h2>
        <p>Laporan Kedisiplinan Siswa Da’il Khairaat</p>
    </div>

    <h3>Biodata Siswa</h3>
    <table class="table">
        <tr><th>NIS</th><td>{{ $siswa->nis }}</td></tr>
        <tr><th>Nama</th><td>{{ $siswa->nama }}</td></tr>
        <tr><th>Kelas</th><td>{{ $siswa->kelas->nama_kelas }}</td></tr>
    </table>

    <h3>Riwayat Pelanggaran</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa->pelanggaran as $p)
            <tr>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                <td>{{ $p->poin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>