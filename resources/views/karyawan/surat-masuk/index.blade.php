@extends('layout.karyawan-template')

@section('title', 'Daftar Surat Masuk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">✉️ Surat Masuk</h4>
        {{-- Tombol Tambah Surat Masuk --}}
        <a href="{{ route('direktur.surat-masuk.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Input Surat Masuk
        </a>
    </div>

    {{-- ALERT UNTUK PESAN SUKSES/ERROR --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">Daftar Surat Masuk untuk Direktur</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Judul & Nomor Surat</th>
                        <th style="width: 20%;">Pengirim</th>
                        <th style="width: 15%;">Tanggal Terima</th>
                        <th style="width: 10%;">Prioritas</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- Loop data dari Controller (variabel $suratMasuk) --}}
                    @forelse($suratMasuk as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong title="{{ $item->nomor_surat ?? 'Tidak Ada Nomor' }}">
                                <a href="{{ route('direktur.surat-masuk.show', $item->id) }}" class="text-primary">
                                    {{ $item->judul }}
                                </a>
                            </strong>
                            <br>
                            <small class="text-muted">{{ $item->nomor_surat ?? 'No. Surat: -' }}</small>

                            {{-- Icon Lampiran --}}
                            @if($item->lampiran)
                                <a href="{{ asset('storage/public/' . $item->lampiran) }}"
                                   target="_blank"
                                   class="ms-1 text-info"
                                   title="Lampiran tersedia">
                                    <i class="bx bx-paperclip"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <strong class="text-dark">{{ $item->pengirim }}</strong>
                            <br>
                            <small class="text-muted" title="{{ $item->keterangan }}">Keterangan: {{ Str::limit($item->keterangan, 30) ?? '-' }}</small>
                        </td>
                        <td>
                            {{-- Menggunakan Carbon untuk format tanggal yang lebih baik --}}
                            <i class="bx bx-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d M Y') }}
                        </td>
                        <td>
                            {{-- Badge Prioritas --}}
                            @php
                                $prioritasClass = [
                                    'tinggi' => 'danger',
                                    'sedang' => 'warning',
                                    'rendah' => 'secondary',
                                ];
                                $currentPrioritas = strtolower($item->prioritas ?? 'rendah');
                            @endphp
                            <span class="badge bg-{{ $prioritasClass[$currentPrioritas] ?? 'secondary' }}">
                                {{ ucfirst($currentPrioritas) }}
                            </span>
                        </td>
                        <td>
                            {{-- Grup Aksi --}}
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('direktur.surat-masuk.show', $item->id) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="{{ route('direktur.surat-masuk.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                                {{-- Form Delete --}}
                                <form action="{{ route('direktur.surat-masuk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus surat {{ $item->judul }}?')">
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
                        <td colspan="6" class="text-center py-4">
                            <i class="bx bx-mail-send bx-lg d-block mb-2 text-muted"></i>
                            <p class="mb-1">Kotak Surat Masuk Anda masih kosong.</p>
                            <a href="{{ route('direktur.surat-masuk.create') }}" class="btn btn-sm btn-outline-primary mt-2">Input Surat Masuk Pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
