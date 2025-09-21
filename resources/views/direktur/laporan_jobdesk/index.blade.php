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
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>Jobdesk</th>
                        <th>Keterangan</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td>Albert Cook</td>
                        <td>Tambang</td>
                        <td>Mengawasi proses pengeboran</td>
                        <td><span class="badge rounded-pill bg-label-primary me-1">Active</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary">Detail</button>
                        </td>
                      </tr>
                      <tr>
                        <td>Siti Rahma</td>
                        <td>Keuangan</td>
                        <td>Membuat laporan mingguan</td>
                        <td><span class="badge rounded-pill bg-label-warning me-1">Proses</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary">Detail</button>
                        </td>
                      </tr>
                      <tr>
                        <td>Budi Santoso</td>
                        <td>Operasional</td>
                        <td>Mengoperasikan alat berat</td>
                        <td><span class="badge rounded-pill bg-label-danger me-1">Belum</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary">Detail</button>
                        </td>
                      </tr>
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
