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
                        <th class="text-truncate">Divisi</th>
                        <th class="text-truncate">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Data dummy users
                        $users = [
                            [
                                'name' => 'Jordan Stevenson',
                                'username' => '@amiccoo',
                                'email' => 'susanna.Lind57@gmail.com',
                                'role' => 'Admin',
                                'status' => 'pending',
                                'avatar' => '../assets/img/avatars/1.png'
                            ],
                            [
                                'name' => 'Siti Rahma',
                                'username' => '@srahma',
                                'email' => 'siti.rahma@example.com',
                                'role' => 'Editor',
                                'status' => 'active',
                                'avatar' => '../assets/img/avatars/3.png'
                            ],
                            [
                                'name' => 'Budi Santoso',
                                'username' => '@bsantoso',
                                'email' => 'budi.santoso@example.com',
                                'role' => 'Author',
                                'status' => 'inactive',
                                'avatar' => '../assets/img/avatars/5.png'
                            ],
                        ];
                    @endphp

                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-4">
                                    <img src="{{ $user['avatar'] }}" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate">{{ $user['name'] }}</h6>
                                    <small class="text-truncate">{{ $user['username'] }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-truncate">{{ $user['email'] }}</td>
                        <td class="text-truncate">
                            <div class="d-flex align-items-center">
                                @if($user['role'] == 'Admin')
                                    <i class="icon-base ri ri-vip-crown-line icon-22px text-primary me-2"></i>
                                @elseif($user['role'] == 'Editor')
                                    <i class="icon-base ri ri-edit-box-line icon-22px text-warning me-2"></i>
                                @else
                                    <i class="icon-base ri ri-computer-line icon-22px text-danger me-2"></i>
                                @endif
                                <span>{{ $user['role'] }}</span>
                            </div>
                        </td>
                        <td>
                             <a href="/direktur/jobdesk-laporan/jobdesk-karyawan/detail/1" class="btn btn-primary btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
