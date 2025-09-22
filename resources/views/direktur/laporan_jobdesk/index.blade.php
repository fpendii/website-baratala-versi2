@extends('layout.direktur-template')

@section('title', 'Laporan Jobdesk Karyawan')

@section('content')
<div class="nav-align-top">
    @include('layout.navigasi-laporan-jobdesk')
    <div class="tab-content">
        <!-- TAB JOBDESK -->
        <div class="tab-pane fade show active">
            <!-- Filter -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Cari nama / jobdesk...">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">Filter Divisi</option>
                        <option value="Tambang">Tambang</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="HRD">HRD</option>
                        <option value="Operasional">Operasional</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>

            <!-- Tabel -->
            @php
            // Data dummy jobdesk
            $jobdesks = [
                [
                    'nama' => 'Albert Cook',
                    'divisi' => 'Tambang',
                    'deskripsi' => 'Mengawasi proses pengeboran',
                    'lampiran' => 'laporan_1.pdf',
                    'status' => 'dikerjakan',
                ],
                [
                    'nama' => 'Siti Rahma',
                    'divisi' => 'Keuangan',
                    'deskripsi' => 'Membuat laporan mingguan',
                    'lampiran' => 'laporan_2.pdf',
                    'status' => 'dikerjakan',
                ],
                [
                    'nama' => 'Budi Santoso',
                    'divisi' => 'Operasional',
                    'deskripsi' => 'Mengoperasikan alat berat',
                    'lampiran' => null,
                    'status' => 'tidak-dikerjakan',
                ],
                [
                    'nama' => 'Dewi Lestari',
                    'divisi' => 'HRD',
                    'deskripsi' => 'Mengatur absensi karyawan',
                    'lampiran' => 'laporan_3.pdf',
                    'status' => 'dikerjakan',
                ],
            ];
            @endphp

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Jobdesk</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($jobdesks as $job)
                        <tr>
                            <td>{{ $job['nama'] }}</td>
                            <td>{{ $job['divisi'] }}</td>
                            <td>{{ $job['deskripsi'] }}</td>
                            <td>
                                @if($job['lampiran'])
                                    <a href="{{ asset('storage/' . $job['lampiran']) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($job['status'] == 'dikerjakan')
                                    <span class="badge rounded-pill bg-label-primary me-1">Dikerjakan</span>
                                @else
                                    <span class="badge rounded-pill bg-label-danger me-1">Belum Dikerjakan</span>
                                @endif
                            </td>
                            <td>
                                <a href="/direktur/laporan-jobdesk/detail/1" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB JOBDESK KARYAWAN -->
        <div class="tab-pane fade" role="tabpanel">
            <p>Konten jobdesk karyawan lain di sini.</p>
        </div>

        <!-- TAB MESSAGES -->
        <div class="tab-pane fade" role="tabpanel">
            <p>Pesan masuk di sini.</p>
        </div>
    </div>
</div>
@endsection
