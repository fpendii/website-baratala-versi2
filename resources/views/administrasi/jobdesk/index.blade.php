@extends('layout.administrasi-template')

@section('title', 'Jobdesk') {{-- Mengubah title sesuai konten --}}

@section('content')
<div class="card">
    <div class="row">
        <div class="col">
            <h5 class="card-header">Jobdesk</h5>
        </div>
        <div class="col">
            <div class="card-header text-end">
                <a href="{{ url('/administrasi/jobdesk/create') }}" class="btn btn-primary">
                    <i class="icon-base ri ri-add-line icon-18px me-1"></i>
                    Tambah
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Jobdesk</th>
                    <th>Divisi</th>
                    {{-- Deskripsi dihilangkan dari tabel utama, dipindahkan ke Modal --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($jobdesks as $index => $jobdesk)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $jobdesk->judul_jobdesk }}</td>
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
                                <a class="dropdown-item" href="{{ route('direktur.jobdesk.edit', $jobdesk->id) }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Edit
                                </a>
                                <form action="{{ url('/direktur/jobdesk/'.$jobdesk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
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
                    <td colspan="4" class="text-center">Belum ada jobdesk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DETAIL JOBDESK --}}
<div class="modal fade" id="detailJobdeskModal" tabindex="-1" aria-hidden="true">
    {{-- Menambahkan modal-dialog-centered agar modal di tengah layar --}}
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">
                    <i class="icon-base ri ri-eye-line me-2"></i> Detail Jobdesk
                </h5>
                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body p-4">
                {{-- JUDUL JOBDESK --}}
                <h3 class="mb-3 text-primary" id="modal-judul-jobdesk"></h3>
                <hr class="mb-4">

                {{-- INFORMASI DIVISI --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <p class="fw-bold mb-0">Divisi:</p>
                        <p id="modal-divisi" class="fs-5 text-dark"></p>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="card bg-light p-3 mb-4">
                    <p class="fw-bold mb-1 text-primary"><i class="icon-base ri ri-text me-1"></i> Deskripsi Jobdesk:</p>
                    <div class="border-start border-3 border-primary ps-3">
                        <p id="modal-deskripsi" style="white-space: pre-wrap;" class="text-dark">-</p>
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
