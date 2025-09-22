@extends('layout.direktur-template')

@section('title', 'Laporan Jobdesk Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Laporan Jobdesk Karyawan - Siti Rahma</h5>
    <a href="/direktur/jobdesk-laporan" class="btn btn-secondary btn-sm">Kembali</a>
</div>

@php
// Dummy data laporan karyawan
$laporanKaryawan = [
    [
        'id' => 1,
        'judul_jobdesk' => 'Laporan Mingguan',
        'deskripsi' => 'Membuat laporan keuangan mingguan untuk evaluasi manajemen',
        'lampiran' => 'laporan_mingguan_1.pdf',
        'status' => 'dikerjakan',
        'created_at' => '2025-09-01 08:00',
    ],
    [
        'id' => 2,
        'judul_jobdesk' => 'Rekap Transaksi',
        'deskripsi' => 'Membuat rekap transaksi harian selama bulan September',
        'lampiran' => 'rekap_transaksi.pdf',
        'status' => 'dikerjakan',
        'created_at' => '2025-09-08 09:15',
    ],
    [
        'id' => 3,
        'judul_jobdesk' => 'Audit Internal',
        'deskripsi' => 'Membantu audit internal keuangan',
        'lampiran' => null,
        'status' => 'tidak-dikerjakan',
        'created_at' => '2025-09-15 10:30',
    ],
];
@endphp

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Jobdesk</th>
                    <th>Deskripsi Laporan</th>
                    <th>Lampiran</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporanKaryawan as $index => $laporan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $laporan['judul_jobdesk'] }}</td>
                    <td>{{ $laporan['deskripsi'] }}</td>
                    <td>
                        @if($laporan['lampiran'])
                            <a href="{{ asset('storage/' . $laporan['lampiran']) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($laporan['status'] == 'dikerjakan')
                            <span class="badge bg-label-primary rounded-pill">Dikerjakan</span>
                        @else
                            <span class="badge bg-label-danger rounded-pill">Belum Dikerjakan</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($laporan['created_at'])->format('d M Y H:i') }}</td>
                    <td>
                        <a href="/direktur/jobdesk-laporan/detail/1" class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
