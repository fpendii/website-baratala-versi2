@extends('layout.direktur-template')

@section('title', 'Laporan Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Laporan Karyawan</h5>
</div>

@php
$laporans = [
    [
        'id' => 1,
        'karyawan' => 'John Doe',
        'judul' => 'Laporan Mingguan Penjualan',
        'deskripsi' => 'Menjelaskan performa penjualan minggu ini secara detail...',
        'lampiran' => null,
        'status' => 'pending',
        'keputusan' => null,
        'created_at' => '2025-09-01 09:00',
        'updated_at' => '2025-09-01 09:15',
    ],
    [
        'id' => 2,
        'karyawan' => 'Maria Smith',
        'judul' => 'Laporan Inventaris',
        'deskripsi' => 'Update stok barang dan pengeluaran inventaris bulan ini...',
        'lampiran' => 'lampiran_inventaris.pdf',
        'status' => 'diterima',
        'keputusan' => 'Laporan diterima dan dicatat di sistem.',
        'created_at' => '2025-09-02 10:30',
        'updated_at' => '2025-09-02 11:00',
    ],
    [
        'id' => 3,
        'karyawan' => 'Alex Johnson',
        'judul' => 'Laporan Kehadiran',
        'deskripsi' => 'Menunjukkan rekap kehadiran karyawan bulan ini.',
        'lampiran' => null,
        'status' => 'ditolak',
        'keputusan' => 'Data tidak lengkap, mohon perbaiki.',
        'created_at' => '2025-09-03 08:45',
        'updated_at' => '2025-09-03 09:10',
    ],
];
@endphp

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Karyawan</th>
                    <th>Judul Laporan</th>
                    <th>Deskripsi</th>
                    <th>Lampiran</th>
                    <th>Status</th>
                    <th>Keputusan</th>
                    <th>Dibuat Pada</th>
                    <th>Diperbarui Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan['id'] }}</td>
                        <td>{{ $laporan['karyawan'] }}</td>
                        <td>{{ $laporan['judul'] }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($laporan['deskripsi'], 50) }}</td>
                        <td>
                            @if($laporan['lampiran'])
                                <a href="{{ asset('storage/' . $laporan['lampiran']) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($laporan['status'] == 'pending')
                                <span class="badge bg-warning rounded-pill">Pending</span>
                            @elseif($laporan['status'] == 'diterima')
                                <span class="badge bg-success rounded-pill">Diterima</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($laporan['keputusan'] ?? '-', 50) }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan['created_at'])->format('d M Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan['updated_at'])->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
