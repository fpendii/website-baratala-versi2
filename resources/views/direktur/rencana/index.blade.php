@extends('layout.direktur-template')

@section('title', 'Rencana Kerja Karyawan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">📋 Rencana Kerja Saya</h4>
        <a href="{{ route('direktur.rencana.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Rencana
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">Daftar Rencana Kerja</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Judul Rencana</th>
                        <th style="width: 18%;">Tanggal</th>
                        <th style="width: 10%;">Prioritas</th>
                        <th style="width: 10%;">Jenis</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>
                                <a href="{{ route('direktur.rencana.show', $item->id) }}"
                                   class="text-primary"
                                   title="{{ $item->deskripsi }}">
                                    {{ $item->judul_rencana }}
                                </a>
                            </strong>
                            @if($item->lampiran)
                                <a href="{{ asset('storage/public/' . $item->lampiran) }}"
                                   target="_blank"
                                   class="ms-1"
                                   title="Lampiran tersedia">
                                    <i class="bx bx-paperclip"></i>
                                </a>
                            @endif
                            <br>
                            <small class="text-muted">
                                Mulai: {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            <small class="d-block text-muted">
                                <i class="bx bx-play-circle"></i> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            </small>
                            <small class="d-block text-muted">
                                <i class="bx bx-flag"></i> {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            @if($item->prioritas == 'Tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($item->prioritas == 'Sedang')
                                <span class="badge bg-warning">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($item->jenis) }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'selesai' => 'success',
                                    'sedang dikerjakan' => 'warning',
                                    'direview' => 'info',
                                    'ditunda' => 'secondary'
                                ];
                                $currentStatus = strtolower($item->status);
                            @endphp
                            <span class="badge bg-{{ $statusClass[$currentStatus] ?? 'secondary' }}">
                                {{ ucfirst($currentStatus) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('direktur.rencana.show', $item->id) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="{{ route('direktur.rencana.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('direktur.rencana.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana kerja ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bx bx-notepad bx-lg d-block mb-2 text-muted"></i>
                            <p class="mb-1">Belum ada Rencana Kerja yang tercatat.</p>
                            <a href="{{ route('direktur.rencana.create') }}" class="btn btn-sm btn-outline-primary">Buat Rencana Pertama Anda</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
