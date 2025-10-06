@extends('layout.karyawan-template')

@section('title', 'Laporan Jobdesk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Laporan Jobdesk Saya</h5>
        <a href="/karyawan/jobdesk/create" class="btn btn-primary btn-sm">Tambah Laporan</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Judul Jobdesk</th>
                        <th>Deskripsi Laporan</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanJobdesks as $item)
                        <tr>
                            <td>{{ $item->jobdesk->judul_jobdesk }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                @if ($item->lampiran)
                                    <a href="{{ asset('storage/public/' . $item->lampiran) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 'diterima')
                                    <span class="badge bg-label-success">{{ $item->status }}</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="badge bg-label-danger">{{ $item->status }}</span>
                                @else
                                    <span class="badge bg-label-warning">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('karyawan.jobdesk.show', $item->id) }}"
                                    class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada laporan jobdesk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
