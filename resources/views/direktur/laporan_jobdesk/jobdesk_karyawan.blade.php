@extends('layout.direktur-template')

@section('title', 'Laporan Jobdesk Karyawan')

@section('content')
    <div class="nav-align-top">
        @include('layout.navigasi-laporan-jobdesk')

        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="text-truncate">User</th>
                            <th class="text-truncate">Email</th>
                            <th class="text-truncate">Role</th>
                            <th class="text-truncate">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-4">
                                        <img src="../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-truncate">Jordan Stevenson</h6>
                                        <small class="text-truncate">@amiccoo</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-truncate">susanna.Lind57@gmail.com</td>
                            <td class="text-truncate">
                                <div class="d-flex align-items-center">
                                    <i class="icon-base ri ri-vip-crown-line icon-22px text-primary me-2"></i>
                                    <span>Admin</span>
                                </div>
                            </td>
                            <td><span class="badge bg-label-warning rounded-pill">Pending</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
