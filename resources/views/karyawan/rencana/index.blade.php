@extends('layout.karyawan-template')

@section('title', 'Rencana Kerja Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Rencana Kerja Saya</h5>
    <a href="/karyawan/rencana/create" class="btn btn-primary btn-sm">Tambah Rencana Kerja</a>
</div>

@php
// Dummy data rencana kerja
$tugas = [
    [
        'judul_rencana' => 'Menyusun Laporan Mingguan',
        'deskripsi' => 'Membuat laporan mingguan kegiatan tim produksi',
        'tanggal_mulai' => '2025-09-23',
        'tanggal_selesai' => '2025-09-25',
        'status' => 'sedang dikerjakan',
        'jenis' => 'rencana',
        'prioritas' => 'Tinggi',
        'lampiran' => null,
        'catatan' => 'Pastikan semua data valid'
    ],
    [
        'judul_rencana' => 'Perbaikan Mesin X',
        'deskripsi' => 'Perintah dari kepala teknik untuk memperbaiki mesin X',
        'tanggal_mulai' => '2025-09-24',
        'tanggal_selesai' => '2025-09-26',
        'status' => 'belum dikerjakan',
        'jenis' => 'perintah',
        'prioritas' => 'Sedang',
        'lampiran' => 'perintah_mesinX.pdf',
        'catatan' => ''
    ],
    [
        'judul_rencana' => 'Pelatihan Keamanan',
        'deskripsi' => 'Mengikuti pelatihan keamanan kerja',
        'tanggal_mulai' => '2025-09-20',
        'tanggal_selesai' => '2025-09-21',
        'status' => 'selesai',
        'jenis' => 'rencana',
        'prioritas' => 'Rendah',
        'lampiran' => null,
        'catatan' => 'Sudah mengikuti pelatihan'
    ],
];
@endphp

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Judul Rencana</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th>Jenis</th>
                    <th>Prioritas</th>
                    <th>Lampiran</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tugas as $item)
                <tr>
                    <td>{{ $item['judul_rencana'] }}</td>
                    <td>{{ $item['deskripsi'] }}</td>
                    <td>{{ $item['tanggal_mulai'] }}</td>
                    <td>{{ $item['tanggal_selesai'] }}</td>
                    <td>
                        @if($item['status'] == 'selesai')
                            <span class="badge bg-label-success">{{ $item['status'] }}</span>
                        @elseif($item['status'] == 'sedang dikerjakan')
                            <span class="badge bg-label-warning">{{ $item['status'] }}</span>
                        @else
                            <span class="badge bg-label-secondary">{{ $item['status'] }}</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($item['jenis']) }}</td>
                    <td>{{ $item['prioritas'] ?? '-' }}</td>
                    <td>
                        @if($item['lampiran'])
                            <a href="/uploads/{{ $item['lampiran'] }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item['catatan'] ?? '-' }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Detail</a>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
