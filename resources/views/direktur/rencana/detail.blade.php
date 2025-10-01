@extends('layout.direktur-template')

@section('title', 'Detail Rencana Kerja')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Rencana Kerja /</span> Detail
    </h4>

    <div class="row">

        {{-- KOLOM KIRI: DETAIL RENCANA KERJA --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Detail Rencana Kerja</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Judul Rencana</dt>
                        <dd class="col-sm-8">{{ $tugas->judul_rencana }}</dd>

                        <dt class="col-sm-4">Deskripsi</dt>
                        <dd class="col-sm-8">{{ $tugas->deskripsi }}</dd>

                        <dt class="col-sm-4">Tanggal Mulai</dt>
                        <dd class="col-sm-8">{{ $tugas->tanggal_mulai }}</dd>

                        <dt class="col-sm-4">Tanggal Selesai</dt>
                        <dd class="col-sm-8">{{ $tugas->tanggal_selesai }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-label-{{ $tugas->status == 'selesai' ? 'success' : ($tugas->status == 'sedang dikerjakan' ? 'warning' : 'secondary') }}">
                                {{ $tugas->status }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Jenis</dt>
                        <dd class="col-sm-8">{{ ucfirst($tugas->jenis) }}</dd>

                        <dt class="col-sm-4">Prioritas</dt>
                        <dd class="col-sm-8">{{ $tugas->prioritas ?? '-' }}</dd>

                        <dt class="col-sm-4">Lampiran</dt>
                        <dd class="col-sm-8">
                            @if($tugas->lampiran)
                                <a href="{{ asset('storage/' . $tugas->lampiran) }}" target="_blank">Lihat Lampiran</a>
                            @else
                                Tidak ada
                            @endif
                        </dd>

                        <dt class="col-sm-4">Catatan</dt>
                        <dd class="col-sm-8">{{ $tugas->catatan ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('direktur.rencana.edit', $tugas->id) }}" class="btn btn-warning">Edit Detail Rencana</a>
                <a href="{{ route('direktur.rencana.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>


        {{-- KOLOM KANAN: PENGGUNA YANG DITUGASKAN (Dapat Diedit) --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pengguna yang Ditugaskan (Edit)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('direktur.rencana.updatePengguna', $tugas->id) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div id="pengguna-list">
                            @foreach($tugas->pengguna as $user)
                                <div class="row mb-2 pengguna-item">
                                    <div class="col-10">
                                        <select name="pengguna[]" class="form-select user-select-field">
                                            <option value="">-- Pilih Pengguna --</option>
                                            @foreach($allUsers as $u)
                                                <option value="{{ $u->id }}" {{ $user->id == $u->id ? 'selected' : '' }}>
                                                    {{ $u->name }} ({{ $u->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-user">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-user">+ Tambah Pengguna</button>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil data user dari Laravel
        const userOptions = @json($allUsers);

        const penggunaList = document.getElementById('pengguna-list');
        const addUserBtn = document.getElementById('add-user');

        // Fungsi untuk mengambil semua ID yang sudah dipilih saat ini
        function getCurrentSelectedIds() {
            const selectedIds = [];
            document.querySelectorAll('.user-select-field').forEach(select => {
                if (select.value) {
                    selectedIds.push(select.value);
                }
            });
            return selectedIds;
        }

        // Fungsi untuk memperbarui opsi di SEMUA select
        function updateSelectOptions() {
            const allSelectedIds = getCurrentSelectedIds();

            // Iterasi melalui setiap select di list
            document.querySelectorAll('.user-select-field').forEach(selectElement => {
                const currentValue = selectElement.value; // Nilai yang sedang dipilih (mungkin kosong)
                selectElement.innerHTML = `<option value="">-- Pilih Pengguna --</option>`; // Reset opsi

                userOptions.forEach(user => {
                    const userIdString = user.id.toString();

                    // Opsi ditampilkan jika:
                    // 1. User ID sama dengan nilai yang sedang dipilih (agar nilai yang sudah dipilih tidak hilang)
                    // 2. User ID belum ada di daftar ID yang dipilih oleh select lain
                    if (userIdString === currentValue || !allSelectedIds.includes(userIdString)) {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = `${user.name} (${user.email})`;

                        if (userIdString === currentValue) {
                            option.selected = true;
                        }
                        selectElement.appendChild(option);
                    }
                });
            });
        }

        // Event handler saat nilai select berubah
        penggunaList.addEventListener('change', function (e) {
            if (e.target.classList.contains('user-select-field')) {
                updateSelectOptions(); // Perbarui semua opsi setelah ada perubahan
            }
        });

        // Function bikin row baru
        function createUserRow() {
            let row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'pengguna-item');

            let selectHtml = `<select name="pengguna[]" class="form-select user-select-field">`;
            selectHtml += `<option value="">-- Pilih Pengguna --</option>`;

            // Dapatkan ID yang sudah dipilih untuk filter saat membuat row baru
            const allSelectedIds = getCurrentSelectedIds();

            userOptions.forEach(user => {
                if (!allSelectedIds.includes(user.id.toString())) {
                    selectHtml += `<option value="${user.id}">${user.name} (${user.email})</option>`;
                }
            });

            selectHtml += `</select>`;

            row.innerHTML = `
                <div class="col-10">
                    ${selectHtml}
                </div>
                <div class="col-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-user">Hapus</button>
                </div>
            `;

            return row;
        }

        // Tambah user
        addUserBtn.addEventListener('click', function () {
            penggunaList.appendChild(createUserRow());
            updateSelectOptions(); // Perlu panggil ini untuk refresh opsi di select lain setelah penambahan
        });

        // Hapus user (event delegation)
        penggunaList.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-user')) {
                e.target.closest('.pengguna-item').remove();
                updateSelectOptions(); // Perbarui semua opsi setelah penghapusan
            }
        });

        // Panggil saat inisialisasi untuk memastikan select awal sudah terfilter
        updateSelectOptions();
    });
</script>

@endsection
