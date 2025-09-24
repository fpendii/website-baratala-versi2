@extends('layout.karyawan-template')

@section('title', 'Laporan Jobdesk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Laporan Jobdesk Saya</h5>
    <a href="/karyawan/jobdesk/create" class="btn btn-primary btn-sm">Tambah Laporan</a>
</div>

@php
// Dummy data laporan jobdesk
$laporan = [
    [
        'judul' => 'Membuat Laporan Mingguan',
        'deskripsi' => 'Membuat laporan mingguan kegiatan tim produksi',
        'lampiran' => 'laporan_mingguan.pdf',
        'status' => 'pending',
        'tanggal' => '2025-09-23'
    ],
    [
        'judul' => 'Perbaikan Mesin X',
        'deskripsi' => 'Melakukan perbaikan mesin X sesuai perintah kepala teknik',
        'lampiran' => null,
        'status' => 'diterima',
        'tanggal' => '2025-09-22'
    ],
];
@endphp

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Lampiran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $item)
                <tr>
                    <td>{{ $item['judul'] }}</td>
                    <td>{{ $item['deskripsi'] }}</td>
                    <td>
                        @if($item['lampiran'])
                            <a href="/uploads/{{ $item['lampiran'] }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item['status'] == 'diterima')
                            <span class="badge bg-label-success">{{ $item['status'] }}</span>
                        @elseif($item['status'] == 'ditolak')
                            <span class="badge bg-label-danger">{{ $item['status'] }}</span>
                        @else
                            <span class="badge bg-label-warning">{{ $item['status'] }}</span>
                        @endif
                    </td>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
