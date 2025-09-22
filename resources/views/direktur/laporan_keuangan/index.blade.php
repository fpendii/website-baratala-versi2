@extends('layout.direktur-template')

@section('title', 'Laporan Keuangan')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6">
        <!-- Ringkasan Keuangan -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Total Pendapatan</h5>
                    <p class="mb-2">Bulan ini</p>
                    <h4 class="text-primary mb-0">$120k</h4>
                    <p class="mb-2">+15% dibanding bulan lalu</p>
                    <a href="javascript:;" class="btn btn-sm btn-primary">Lihat Detail</a>
                </div>
                <img src="/image/icon-uang.png" class="position-absolute bottom-0 end-0 me-5 mb-5"
                    width="83" alt="pendapatan" />
            </div>
        </div>

        <!-- Statistik Keuangan -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Ringkasan Bulanan</h5>
                    </div>
                    <p class="small mb-0"><span class="h6 mb-0">Laba Bersih $75k</span> bulan ini</p>
                </div>
                <div class="card-body pt-lg-10">
                    <div class="row g-6">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-primary rounded shadow-xs">
                                        <i class="icon-base ri ri-bar-chart-line icon-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Pendapatan</p>
                                    <h5 class="mb-0">$120k</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-danger rounded shadow-xs">
                                        <i class="icon-base ri ri-arrow-down-line icon-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Pengeluaran</p>
                                    <h5 class="mb-0">$45k</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-success rounded shadow-xs">
                                        <i class="icon-base ri ri-line-chart-line icon-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Laba Bersih</p>
                                    <h5 class="mb-0">$75k</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-warning rounded shadow-xs">
                                        <i class="icon-base ri ri-pie-chart-2-line icon-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Pertumbuhan</p>
                                    <h5 class="mb-0">+15%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi Keuangan -->
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-truncate">Tanggal</th>
                                <th class="text-truncate">Deskripsi</th>
                                <th class="text-truncate">Jenis</th>
                                <th class="text-truncate">Jumlah</th>
                                <th class="text-truncate">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025-09-01</td>
                                <td>Penjualan Produk A</td>
                                <td>Pendapatan</td>
                                <td class="text-success">$5,000</td>
                                <td><span class="badge bg-success rounded-pill">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>2025-09-02</td>
                                <td>Pembelian Bahan Baku</td>
                                <td>Pengeluaran</td>
                                <td class="text-danger">-$1,200</td>
                                <td><span class="badge bg-warning rounded-pill">Pending</span></td>
                            </tr>
                            <tr>
                                <td>2025-09-05</td>
                                <td>Gaji Karyawan</td>
                                <td>Pengeluaran</td>
                                <td class="text-danger">-$2,500</td>
                                <td><span class="badge bg-success rounded-pill">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>2025-09-10</td>
                                <td>Penjualan Produk B</td>
                                <td>Pendapatan</td>
                                <td class="text-success">$7,500</td>
                                <td><span class="badge bg-success rounded-pill">Selesai</span></td>
                            </tr>
                            <!-- Tambahkan data transaksi lainnya -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
