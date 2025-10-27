<!DOCTYPE html>
<html>
<head>
    <title>Bukti Persetujuan Pengeluaran</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .info-box { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .ttd-section { margin-top: 50px; }
        .ttd-box { width: 45%; float: left; text-align: center; margin: 0 2%; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BUKTI PENGELUARAN KAS / PERSETUJUAN LAPORAN KEUANGAN</h1>
        <p>PT. {{ config('app.name', 'Nama Perusahaan Anda') }}</p>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td style="width: 30%;">Nomor Laporan</td>
                <td>: {{ $laporan->id }}</td>
            </tr>
            <tr>
                <td>Tanggal Disetujui</td>
                <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Keterangan Pengeluaran</td>
                <td>: {{ $laporan->keterangan }}</td>
            </tr>
        </table>
    </div>

    <h3>Detail Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Nominal Pengeluaran</th>
                <th>Penerima</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $laporan->jenis }} ({{ $laporan->kategori }})</td>
                <td>Rp. {{ number_format($laporan->nominal, 0, ',', '.') }}</td>
                <td>{{ $laporan->penerimaRelasi->nama ?? $laporan->penerima }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Catatan Persetujuan Direktur</h3>
    <div class="info-box">
        <p style="font-style: italic; white-space: pre-wrap;">{{ $laporan->catatan ?? 'Tidak ada catatan khusus.' }}</p>
    </div>

    <div class="ttd-section clearfix">
        <div class="ttd-box">
            <p>Disiapkan oleh,</p>
            <br><br><br>
            <p>( {{ $laporan->pengguna->nama ?? 'Nama Karyawan' }} )</p>
            <p>Staf/Bagian Keuangan</p>
        </div>

        <div class="ttd-box">
            <p>Disetujui oleh,</p>
            <br><br><br>
            {{-- Asumsi Direktur adalah user yang sedang login atau diambil dari data --}}
            <p>( {{ Auth::user()->nama ?? 'Nama Direktur' }} )</p>
            <p>Direktur Utama</p>
        </div>
    </div>

</body>
</html>
