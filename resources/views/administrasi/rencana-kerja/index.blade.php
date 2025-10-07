@extends('layout.administrasi-template')

@section('title', 'Rencana Kerja Administrasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Rencana Kerja Saya</h5>
        <a href="{{ url('administrasi/rencana/create') }}" class="btn btn-primary btn-sm">Tambah Rencana Kerja</a>
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
                                @if ($item->status == 'selesai')
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
                                @if ($item->lampiran)
                                    <a href="{{ asset('storage/public/' . $item->lampiran) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->catatan ?? '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ url('administrasi/rencana/' . $item->id) }}">
                                            <i class="icon-base ri ri-eye-line icon-18px me-1"></i>
                                            Detail
                                        </a>
                                        <a class="dropdown-item" href="{{ url('administrasi/rencana/edit/' . $item->id) }}">
                                            <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ url('/administrasi/rencana/delete/' . $item->id) }}" method="POST"
                                            style="display: contents;" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </div>
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
