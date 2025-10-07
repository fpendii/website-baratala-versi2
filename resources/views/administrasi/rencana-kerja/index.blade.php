@extends('layout.administrasi-template')

@section('title', 'Rencana Kerja Administrasi')

@section('content')
<div class="card">
    <div class="row">
        {{-- Header dan Tombol Tambah --}}
        <div class="col">
            <h5 class="card-header">Rencana Kerja Saya</h5>
        </div>
        <div class="col">
            <div class="card-header text-end">
                <a href="{{ url('administrasi/rencana/create') }}" class="btn btn-primary">
                    <i class="icon-base ri ri-add-line icon-18px me-1"></i>
                    Tambah Rencana
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel Ringkas --}}
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Rencana</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($tugas as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->judul_rencana }}</td>
                    <td>{{ $item->tanggal_mulai }}</td>
                    <td>{{ $item->tanggal_selesai }}</td>
                    <td>
                        {{-- Logika Badge Status --}}
                        @php
                            $statusClass = 'secondary';
                            if ($item->status == 'selesai') $statusClass = 'success';
                            elseif($item->status == 'sedang dikerjakan') $statusClass = 'warning';
                        @endphp
                        <span class="badge bg-label-{{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                    </td>
                    <td>{{ $item->prioritas ?? '-' }}</td>
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
                                   data-bs-target="#detailRencanaModal"
                                   data-judul="{{ $item->judul_rencana }}"
                                   data-deskripsi="{{ $item->deskripsi }}"
                                   data-tgl-mulai="{{ $item->tanggal_mulai }}"
                                   data-tgl-selesai="{{ $item->tanggal_selesai }}"
                                   data-status="{{ ucfirst($item->status) }}"
                                   data-jenis="{{ ucfirst($item->jenis) }}"
                                   data-prioritas="{{ $item->prioritas ?? '-' }}"
                                   data-lampiran="{{ $item->lampiran ? asset('storage/' . $item->lampiran) : '' }}"
                                   data-catatan="{{ $item->catatan ?? '-' }}">
                                    <i class="icon-base ri ri-eye-line icon-18px me-1"></i>
                                    Detail
                                </a>
                                {{-- Tombol Edit dan Delete (tetap sama) --}}
                                <a class="dropdown-item" href="{{ url('administrasi/rencana/edit/' . $item->id) }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Edit
                                </a>
                                <form action="{{ url('/administrasi/rencana/delete/' . $item->id) }}" method="POST"
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
                    <td colspan="7" class="text-center">Belum ada rencana</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{-- MODAL DETAIL RENCANA KERJA YANG LEBIH MENARIK --}}
<div class="modal fade" id="detailRencanaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">
                    <i class="icon-base ri ri-eye-line me-2"></i> Detail Rencana Kerja
                </h5>
                <button
                    type="button"
                    class="btn-close btn-close-white" {{-- Menggunakan class btn-close-white untuk kontras --}}
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body p-4">
                {{-- JUDUL RENCANA --}}
                <h3 class="mb-3 text-primary" id="modal-judul-rencana"></h3>
                <hr class="mb-4">

                {{-- STATUS, JENIS, PRIORITAS, TANGGAL --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <p class="fw-bold mb-0">Status:</p>
                        <p id="modal-status" class="fs-5"></p> {{-- FS-5 untuk ukuran lebih besar --}}
                    </div>
                    <div class="col-md-3">
                        <p class="fw-bold mb-0">Jenis:</p>
                        <p id="modal-jenis" class="text-dark">-</p>
                    </div>
                    <div class="col-md-3">
                        <p class="fw-bold mb-0">Prioritas:</p>
                        <p id="modal-prioritas" class="text-dark">-</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="fw-bold mb-0">Tanggal Mulai:</p>
                        <p id="modal-tgl-mulai" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <p class="fw-bold mb-0">Tanggal Selesai:</p>
                        <p id="modal-tgl-selesai" class="text-muted"></p>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="card bg-light p-3 mb-4">
                    <p class="fw-bold mb-1 text-primary"><i class="icon-base ri ri-text me-1"></i> Deskripsi:</p>
                    <div class="border-start border-3 border-primary ps-3">
                        <p id="modal-deskripsi" style="white-space: pre-wrap;" class="text-dark">-</p>
                    </div>
                </div>

                {{-- CATATAN --}}
                <div class="card p-3 mb-4">
                    <p class="fw-bold mb-1 text-info"><i class="icon-base ri ri-information-line me-1"></i> Catatan:</p>
                    <div class="border-start border-3 border-info ps-3">
                        <p id="modal-catatan" style="white-space: pre-wrap;" class="text-dark">-</p>
                    </div>
                </div>

                {{-- LAMPIRAN --}}
                <div class="mb-3">
                    <p class="fw-bold mb-1"><i class="icon-base ri ri-attachment-line me-1"></i> Lampiran:</p>
                    <p id="modal-lampiran-wrapper">
                        <span id="modal-lampiran-kosong" class="text-muted">Tidak ada lampiran</span>
                        <a href="#" id="modal-lampiran-link" target="_blank" class="btn btn-sm btn-outline-primary" style="display:none;">
                            <i class="icon-base ri ri-file-text-line me-1"></i> Lihat Lampiran
                        </a>
                    </p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
    </div>

</div>


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailModal = document.getElementById('detailRencanaModal');

        // Pastikan modal dan Bootstrap JS sudah dimuat
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function (event) {
                // Tombol yang memicu modal (yaitu tombol 'Detail')
                const button = event.relatedTarget;

                // Ambil data dari atribut data-*, pastikan ada nilai default jika null
                const judul = button.getAttribute('data-judul') ?? 'N/A';
                const deskripsi = button.getAttribute('data-deskripsi') ?? '-';
                const tglMulai = button.getAttribute('data-tgl-mulai') ?? '-';
                const tglSelesai = button.getAttribute('data-tgl-selesai') ?? '-';
                const status = button.getAttribute('data-status') ?? '-';
                const jenis = button.getAttribute('data-jenis') ?? '-';
                const prioritas = button.getAttribute('data-prioritas') ?? '-';
                const lampiran = button.getAttribute('data-lampiran'); // Tidak perlu default '-'
                const catatan = button.getAttribute('data-catatan') ?? '-';

                // Fungsi helper untuk mendapatkan class badge
                function getStatusClass(s) {
                    const lowerStatus = s.toLowerCase();
                    if (lowerStatus === 'selesai') return 'success';
                    if (lowerStatus === 'sedang dikerjakan') return 'warning';
                    return 'secondary';
                }

                // Update konten modal
                document.getElementById('modal-judul-rencana').textContent = judul;
                document.getElementById('modal-tgl-mulai').textContent = tglMulai;
                document.getElementById('modal-tgl-selesai').textContent = tglSelesai;

                // Update status dengan badge
                document.getElementById('modal-status').innerHTML = `<span class="badge bg-label-${getStatusClass(status)}">${status}</span>`;

                document.getElementById('modal-jenis').textContent = jenis;
                document.getElementById('modal-prioritas').textContent = prioritas;
                document.getElementById('modal-deskripsi').textContent = deskripsi;
                document.getElementById('modal-catatan').textContent = catatan;

                // Handle Lampiran
                const lampiranLink = document.getElementById('modal-lampiran-link');
                const lampiranKosong = document.getElementById('modal-lampiran-kosong');

                if (lampiran) {
                    lampiranLink.href = lampiran;
                    lampiranLink.style.display = 'inline';
                    lampiranKosong.style.display = 'none';
                } else {
                    lampiranLink.style.display = 'none';
                    lampiranKosong.style.display = 'inline';
                }
            });
        }
    });
</script>
@endpush
