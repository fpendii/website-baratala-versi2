@extends('layout.karyawan-template')

@section('title', 'Rencana Kerja Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Rencana Kerja Saya</h5>
    <a href="{{ route('karyawan.rencana.create') }}" class="btn btn-primary btn-sm">Tambah Rencana Kerja</a>
</div>

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
                @forelse($tugas as $item)
                <tr>
                    <td>{{ $item->judul_rencana }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->tanggal_mulai }}</td>
                    <td>{{ $item->tanggal_selesai }}</td>
                    <td>
                        @if($item->status == 'selesai')
                            <span class="badge bg-label-success">{{ $item->status }}</span>
                        @elseif($item->status == 'sedang dikerjakan')
                            <span class="badge bg-label-warning">{{ $item->status }}</span>
                        @else
                            <span class="badge bg-label-secondary">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td>{{ $item->prioritas ?? '-' }}</td>
                    <td>
                        @if($item->lampiran)
                            <a href="{{ asset('storage/public/' . $item->lampiran) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->catatan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('karyawan.rencana.show', $item->id) }}" class="btn btn-sm btn-primary">Detail</a>
                        <a href="{{ route('karyawan.rencana.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('karyawan.rencana.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus rencana ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Belum ada rencana</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
