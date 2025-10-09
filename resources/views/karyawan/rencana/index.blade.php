@extends('layout.karyawan-template')

@section('title', 'Rencana Kerja Saya')

@section('content')
    {{-- Header dengan Judul dan Tombol Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <i class="bx bx-calendar-check me-2 text-primary"></i> Rencana Kerja Saya
        </h4>
        <a href="{{ route('karyawan.rencana.create') }}" class="btn btn-primary shadow-sm">
            <i class="icon-base ri ri-add-line icon-18px me-1"></i> Tambah
        </a>
    </div>

    {{-- Alert Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card Daftar Rencana Kerja --}}
    <div class="card">
        <h5 class="card-header border-bottom">Daftar Semua Rencana Kerja</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Rencana Kerja & Detail</th>
                        <th style="width: 15%;">Periode & Batas Waktu</th>
                        <th style="width: 5%;">Prioritas</th>
                        <th style="width: 5%;">Status</th>
                        <th style="width: 10%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($tugas as $index => $item)
                        <tr>
                            <td><span class="fw-bold">{{ $index + 1 }}</span></td>
                            <td>
                                <strong class="text-dark">
                                    <a href="{{ route('karyawan.rencana.show', $item->id) }}"
                                        class="text-decoration-none text-primary"
                                        title="Lihat Detail: {{ $item->judul_rencana }}">
                                        {{ $item->judul_rencana }}
                                    </a>
                                </strong>
                                @if ($item->lampiran)
                                    <a href="{{ asset('storage/public/' . $item->lampiran) }}" target="_blank"
                                        class="ms-1 text-info" title="Lampiran tersedia">
                                        <i class="bx bx-paperclip"></i>
                                    </a>
                                @endif
                                <br>
                                <small class="text-muted d-block mt-1">
                                    <i class="bx bx-hash me-1"></i> Jenis: {{ ucfirst($item->jenis) }}
                                </small>
                            </td>
                            <td>
                                {{-- Tanggal Mulai --}}
                                <span class="d-block text-muted">
                                    <i class="bx bx-play-circle me-1"></i> Mulai:
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                </span>
                                {{-- Tanggal Selesai (Batas Waktu) --}}
                                <span class="d-block text-muted">
                                    <i class="bx bx-calendar-check me-1"></i> Batas:
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </span>

                                {{-- Indikator Keterlambatan / Sisa Hari --}}
                                @php
                                    $deadline = \Carbon\Carbon::parse($item->tanggal_selesai);
                                    $isOverdue = $deadline->isPast() && strtolower($item->status) != 'selesai';
                                    $remainingDays = now()->diffInDays($deadline, false);
                                @endphp
                                @if ($isOverdue)
                                    <span class="badge bg-danger mt-1">Terlambat</span>
                                @elseif ($remainingDays <= 3 && $remainingDays >= 0)
                                    {{-- Menggunakan (int) untuk memastikan angka yang ditampilkan adalah bilangan bulat --}}
                                    <span class="badge bg-warning mt-1">Deadline Dekat ({{ (int) $remainingDays }}
                                        hari)</span>
                                @elseif ($remainingDays < 0)
                                    {{-- Jika status sudah selesai, jangan tampilkan Terlambat lagi, tapi tidak ada lagi sisa hari --}}
                                @else
                                    {{-- Menggunakan (int) untuk memastikan angka yang ditampilkan adalah bilangan bulat --}}
                                    <span class="badge bg-label-info mt-1">Sisa {{ (int) $remainingDays }} hari</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $prioritasClass = [
                                        'tinggi' => 'danger',
                                        'sedang' => 'warning',
                                        'rendah' => 'secondary',
                                    ];
                                    $currentPrioritas = strtolower($item->prioritas);
                                @endphp
                                <span class="badge bg-{{ $prioritasClass[$currentPrioritas] ?? 'light' }}">
                                    {{ ucfirst($currentPrioritas) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'selesai' => 'success',
                                        'sedang dikerjakan' => 'primary',
                                        'direview' => 'info',
                                        'ditunda' => 'secondary',
                                        'belum dikerjakan' => 'warning',
                                    ];
                                    $currentStatus = strtolower($item->status);
                                @endphp
                                <span class="badge bg-label-{{ $statusClass[$currentStatus] ?? 'secondary' }}">
                                    {{ ucfirst($currentStatus) }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ url('karyawan/rencana/'.$item->id.'/edit') }}">
                                            <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ url('/karyawan/rencana/' . $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus data ini?')">
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
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-calendar-plus bx-lg d-block mb-3 text-muted"></i>
                                <h6 class="mb-1 text-dark">Belum ada Rencana Kerja yang Anda buat.</h6>
                                <p class="text-muted">Ayo mulai catat rencana kerja Anda untuk minggu/bulan ini!</p>
                                <a href="{{ route('karyawan.rencana.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="bx bx-plus me-1"></i> Buat Rencana
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
