@extends('layout.direktur-template')

@section('title', 'Detail Laporan Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Detail Laporan Karyawan</h5>
    <a href="/direktur/laporan" class="btn btn-secondary btn-sm">Kembali</a>
</div>

@php
// Data dummy laporan
$laporan = [
    'id' => 1,
    'karyawan' => 'Maria Smith',
    'judul' => 'Laporan Inventaris Bulanan',
    'deskripsi' => 'Update stok barang dan pengeluaran inventaris bulan ini. Semua data telah dicatat dan diverifikasi.',
    'lampiran' => 'lampiran_inventaris.pdf',
    'status' => 'diterima',
    'keputusan' => 'Laporan diterima dan dicatat di sistem.',
    'created_at' => '2025-09-02 10:30',
    'updated_at' => '2025-09-02 11:00',
];
@endphp

<div class="card">
    <div class="card-body">
        <h6 class="card-title mb-2">Judul Laporan</h6>
        <p>{{ $laporan['judul'] }}</p>

        <h6 class="card-title mb-2">Karyawan</h6>
        <p>{{ $laporan['karyawan'] }}</p>

        <h6 class="card-title mb-2">Deskripsi</h6>
        <p>{{ $laporan['deskripsi'] }}</p>

        <h6 class="card-title mb-2">Lampiran</h6>
        <p>
            @if($laporan['lampiran'])
                <a href="{{ asset('storage/' . $laporan['lampiran']) }}" target="_blank">Lihat Lampiran</a>
            @else
                Tidak ada lampiran
            @endif
        </p>

        <h6 class="card-title mb-2">Status</h6>
        <p>
            @if($laporan['status'] == 'pending')
                <span class="badge bg-warning rounded-pill">Pending</span>
            @elseif($laporan['status'] == 'diterima')
                <span class="badge bg-success rounded-pill">Diterima</span>
            @else
                <span class="badge bg-danger rounded-pill">Ditolak</span>
            @endif
        </p>

        <h6 class="card-title mb-2">Keputusan</h6>
        <p>{{ $laporan['keputusan'] ?? '-' }}</p>

        <h6 class="card-title mb-2">Tanggal Dibuat</h6>
        <p>{{ \Carbon\Carbon::parse($laporan['created_at'])->format('d M Y H:i') }}</p>

        <h6 class="card-title mb-2">Tanggal Diperbarui</h6>
        <p>{{ \Carbon\Carbon::parse($laporan['updated_at'])->format('d M Y H:i') }}</p>
    </div>
</div>
@endsection
