@extends('layout.app')

@section('title', 'Jobdesk')

@section('content')
{{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon-base ri ri-check-line me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="icon-base ri ri-error-warning-line me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Pengecekan untuk error validasi setelah redirect dari Store/Update --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="icon-base ri ri-error-warning-line me-1"></i>
            Gagal menyimpan data. Mohon periksa kembali formulir Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="row align-items-center">
            <div class="col-md-6 col-12">
                <h5 class="card-header">Daftar Jobdesk</h5>
            </div>
            <div class="col-md-6 col-12 text-md-end">
                <div class="card-header">
                    <a href="{{ url('//jobdesk/create') }}" class="btn btn-primary">
                        <i class="icon-base ri ri-add-line icon-18px me-1"></i> Tambah Jobdesk
                    </a>
                </div>
            </div>
        </div>

        <hr class="mt-0">

        {{--------------------------------------------------}}
        {{-- START: FORM FILTER DAN PENCARIAN --}}
        {{--------------------------------------------------}}
        <form method="GET" action="{{ url()->current() }}" class="px-4 pb-4">
            <div class="row g-3 align-items-end">

                {{-- Filter Divisi --}}
                <div class="col-lg-3 col-md-4 col-12">
                    <label for="filter_divisi" class="form-label fw-medium">Filter Divisi</label>
                    <select name="divisi" id="filter_divisi" class="form-select form-select-sm">
                        <option value="semua">-- Semua Divisi --</option>
                        @php
                            $currentDivisi = request('divisi', 'semua');
                        @endphp
                        {{-- Loop menggunakan data yang dikirim dari Controller --}}
                        @foreach ($availableDivisions as $divisi)
                            <option value="{{ $divisi }}" {{ $currentDivisi == $divisi ? 'selected' : '' }}>
                                {{ $divisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pencarian Teks --}}
                <div class="col-lg-5 col-md-8 col-12">
                    <label for="filter_cari" class="form-label fw-medium">Cari Judul Jobdesk</label>
                    <input type="text" name="cari" id="filter_cari" class="form-control form-control-sm"
                           placeholder="Masukkan Judul Jobdesk..."
                           value="{{ request('cari') }}">
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-lg-4 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-info btn-sm me-2">
                        <i class="icon-base ri ri-filter-line me-1"></i> Filter
                    </button>
                    {{-- Tombol Reset --}}
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm">
                        <i class="icon-base ri ri-refresh-line me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
        {{--------------------------------------------------}}
        {{-- END: FORM FILTER DAN PENCARIAN --}}
        {{--------------------------------------------------}}

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Judul Jobdesk</th>
                        <th style="width: 20%">Divisi</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($jobdesks as $index => $jobdesk)
                    <tr>
                        {{-- Menggunakan firstItem() dari Pagination untuk penomoran yang benar --}}
                        <td>{{ $jobdesks->firstItem() + $index }}</td>
                        <td>{{ Str::limit($jobdesk->judul_jobdesk, 50, '...') }}</td>
                        <td>{{ $jobdesk->divisi }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    {{-- Tombol Detail yang Memicu Modal --}}
                                    <a class="dropdown-item btn-detail" href="javascript:void(0);"
                                       data-bs-toggle="modal"
                                       data-bs-target="#detailJobdeskModal"
                                       data-judul="{{ $jobdesk->judul_jobdesk }}"
                                       data-deskripsi="{{ $jobdesk->deskripsi }}"
                                       data-divisi="{{ $jobdesk->divisi }}">
                                        <i class="icon-base ri ri-eye-line icon-18px me-1"></i>
                                        Detail
                                    </a>
                                    {{-- Tombol Edit menggunakan route yang sudah ada --}}
                                    <a class="dropdown-item" href="{{ url('/jobdesk/edit', $jobdesk->id) }}">
                                        <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                        Edit
                                    </a>
                                    <form action="{{ url('/jobdesk/delete/'.$jobdesk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
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
                        <td colspan="4" class="text-center">Belum ada jobdesk yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Area Pagination --}}
        {{-- @if(isset($jobdesks) && method_exists($jobdesks, 'links'))
            <div class="card-body">
                {{ $jobdesks->appends(request()->except('page'))->links() }}
            </div>
        @endif --}}
    </div>

{{-- MODAL DETAIL JOBDESK --}}
<div class="modal fade" id="detailJobdeskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="icon-base ri ri-eye-line me-2"></i> Detail Jobdesk
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body p-4">

                {{-- JUDUL JOBDESK (Field Penuh) --}}
                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">Judul Jobdesk</label>
                    <div class="border p-2 rounded bg-light">
                        <h4 class="mb-0 text-dark" id="modal-judul-jobdesk"></h4>
                    </div>
                </div>

                <hr class="mb-4 mt-0">

                {{-- INFORMASI DIVISI --}}
                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">Divisi</label>
                    <p class="border p-2 rounded mb-0 text-dark fs-5" id="modal-divisi">-</p>
                </div>

                <hr class="mb-4">

                {{-- DESKRIPSI (Gaya Card yang Lebih Rapi) --}}
                <div class="mb-4">
                    <label class="form-label fw-bold text-primary mb-2">
                        <i class="icon-base ri ri-file-text-line me-1"></i> Deskripsi Jobdesk
                    </label>
                    <div class="border p-3 rounded bg-light">
                        <p id="modal-deskripsi" style="white-space: pre-wrap;" class="mb-0 text-dark">-</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailModal = document.getElementById('detailJobdeskModal');

        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function (event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget;

                // Ambil data dari atribut data-*
                const judul = button.getAttribute('data-judul') ?? 'N/A';
                const deskripsi = button.getAttribute('data-deskripsi') ?? '-';
                const divisi = button.getAttribute('data-divisi') ?? '-';

                // Update konten modal
                document.getElementById('modal-judul-jobdesk').textContent = judul;
                document.getElementById('modal-divisi').textContent = divisi;
                document.getElementById('modal-deskripsi').textContent = deskripsi;
            });
        }
    });
</script>
@endpush
