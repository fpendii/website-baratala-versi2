@extends('layout.app')

@section('title', 'Daftar Surat Keluar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">Surat Keluar</h4>
        {{-- Tombol Tambah Surat Keluar --}}
        {{-- Menggunakan rute resource standar: surat-keluar.create --}}
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
            <i class="icon-base ri ri-add-line icon-18px me-1"></i> Tambah
        </a>
    </div>

    {{-- ALERT UNTUK PESAN SUKSES/ERROR --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">Daftar Surat Keluar</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Perihal & Nomor Surat</th>
                        <th style="width: 20%;">Tujuan Surat</th>
                        <th style="width: 15%;">Tanggal Surat</th>
                        <th style="width: 10%;">Jenis Surat</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- Loop data dari Controller (asumsi variabelnya adalah $surat_keluar) --}}
                    @forelse($surat_keluar as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong title="{{ $item->nomor_surat }}">
                                    {{-- Menggunakan route show standar untuk detail --}}
                                    <a href="{{ route('surat-keluar.show', $item->id) }}" class="text-primary">
                                        {{ $item->perihal }}
                                    </a>
                                </strong>
                                <br>
                                <small class="text-muted">No. Surat: {{ $item->nomor_surat }}</small>
                            </td>
                            <td>
                                {{-- Menampilkan Tujuan Surat --}}
                                <strong class="text-dark">{{ $item->tujuan }}</strong>
                                <br>
                                {{-- Menampilkan siapa yang upload --}}
                                <small class="text-muted" title="Dibuat oleh {{ $item->pengguna->name ?? 'Pengguna Tidak Ditemukan' }}">
                                    Dibuat oleh: {{ Str::limit($item->pengguna->name ?? 'N/A', 25) }}
                                </small>
                            </td>
                            <td>
                                {{-- Menggunakan Carbon untuk format tanggal tgl_surat --}}
                                <i class="bx bx-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tgl_surat)->format('d M Y') }}
                            </td>
                            <td>
                                {{-- Badge Jenis Surat --}}
                                @php
                                    $jenisClass = [
                                        'keuangan' => 'success',
                                        'operasional' => 'warning',
                                        'umum' => 'info',
                                    ];
                                    $currentJenis = strtolower($item->jenis_surat ?? 'umum');
                                @endphp
                                <span class="badge bg-{{ $jenisClass[$currentJenis] ?? 'secondary' }}">
                                    {{ ucfirst($currentJenis) }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">

                                        {{-- TOMBOL DETAIL (Memicu Modal) --}}
                                        <a href="javascript:void(0);" class="dropdown-item btn-detail-surat"
                                            data-bs-toggle="modal" data-bs-target="#detailSuratModal"
                                            {{-- Data Attributes untuk injeksi ke Modal --}}
                                            data-perihal="{{ $item->perihal }}"
                                            data-nomor="{{ $item->nomor_surat }}"
                                            data-tujuan="{{ $item->tujuan }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($item->tgl_surat)->format('d F Y') }}"
                                            data-jenis="{{ ucfirst($currentJenis) }}">
                                            <i class="icon-base ri ri-eye-line icon-18px me-1"></i> Detail
                                        </a>

                                        {{-- hanya pegguna yang upload bisa edit dan hapus --}}
                                        @if ($item->id_pengguna == Auth::id())
                                            {{-- Tombol Edit (Menggunakan route resource standar) --}}
                                            <a class="dropdown-item"
                                                href="{{ route('surat-keluar.edit', $item->id) }}">
                                                <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                                Edit
                                            </a>
                                            {{-- Tombol Delete (Menggunakan route resource standar) --}}
                                            <form action="{{ route('surat-keluar.destroy', $item->id) }}"
                                                method="POST" style="display: contents;"
                                                onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bx bx-envelope-open bx-lg d-block mb-2 text-muted"></i>
                                <p class="mb-1">Belum ada data Surat Keluar yang tercatat.</p>
                                <a href="{{ route('surat-keluar.create') }}"
                                    class="btn btn-sm btn-outline-primary mt-2">Buat Surat Keluar Pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
    {{-- ================================================================= --}}
    {{-- MODAL DETAIL SURAT KELUAR --}}
    {{-- ================================================================= --}}
    <div class="modal fade" id="detailSuratModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-envelope-open me-2 text-primary"></i> Detail Surat Keluar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    {{-- Bagian Informasi Surat --}}
                    <h6 class="text-primary border-bottom pb-2 mb-3">Informasi Surat</h6>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <strong class="d-block mb-1">Perihal Surat:</strong>
                            <h4 class="fw-bold text-dark" id="detailPerihal"></h4>
                        </div>
                    </div>

                    {{-- Detail Metadata Surat menggunakan List Group --}}
                    <ul class="list-group list-group-flush mb-4 border rounded">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <i class="bx bx-hash me-2 text-info"></i>
                                <strong>Nomor Surat:</strong>
                            </div>
                            <span id="detailNomor" class="text-wrap text-end text-dark fw-medium"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <i class="bx bx-send me-2 text-success"></i>
                                <strong>Tujuan:</strong>
                            </div>
                            <span id="detailTujuan" class="text-wrap text-end text-dark fw-medium"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <i class="bx bx-calendar me-2 text-secondary"></i>
                                <strong>Tanggal Surat:</strong>
                            </div>
                            <span id="detailTanggal" class="text-wrap text-end text-dark fw-medium"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <i class="bx bx-cog me-2 text-warning"></i>
                                <strong>Jenis Surat:</strong>
                            </div>
                            {{-- Jenis akan diisi oleh JS sebagai badge --}}
                            <span id="detailJenis"></span>
                        </li>
                    </ul>

                    {{-- Bagian Perihal (Sebagai Detail) --}}
                    <h6 class="text-primary border-bottom pb-2 mb-3">Isi Perihal</h6>
                    <div class="p-3 bg-light rounded mb-4">
                        <p style="white-space: pre-wrap; margin-bottom: 0;" class="text-secondary" id="detailPerihalContent">
                        </p>
                    </div>

                    {{-- Bagian Lampiran Dihilangkan karena tidak ada di skema --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailModal = document.getElementById('detailSuratModal');

            // Fungsi yang dijalankan saat modal akan ditampilkan
            detailModal.addEventListener('show.bs.modal', function(event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget;

                // Ekstrak data dari data-* attributes yang disematkan di tombol (diberi nama sesuai skema surat_keluar)
                const perihal = button.getAttribute('data-perihal');
                const nomor = button.getAttribute('data-nomor');
                const tujuan = button.getAttribute('data-tujuan');
                const tanggal = button.getAttribute('data-tanggal');
                const jenis = button.getAttribute('data-jenis');

                // Tentukan kelas badge untuk Jenis Surat
                let badgeClass = 'secondary';
                if (jenis.toLowerCase() === 'keuangan') {
                    badgeClass = 'success';
                } else if (jenis.toLowerCase() === 'operasional') {
                    badgeClass = 'warning';
                } else if (jenis.toLowerCase() === 'umum') {
                    badgeClass = 'info';
                }

                // Update konten modal
                document.getElementById('detailPerihal').textContent = perihal;
                document.getElementById('detailPerihalContent').textContent = perihal; // Perihal juga diulang sebagai isi
                document.getElementById('detailNomor').textContent = nomor;
                document.getElementById('detailTujuan').textContent = tujuan;
                document.getElementById('detailTanggal').textContent = tanggal;
                document.getElementById('detailJenis').innerHTML =
                    `<span class="badge bg-${badgeClass}">${jenis}</span>`;
            });
        });
    </script>
@endsection
