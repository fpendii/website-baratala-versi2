@extends('layout.direktur-template')

@section('title', 'Profil Karyawan')

@section('content')
<div class="card mb-6">
    <!-- Account -->
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-6">
            <img  src="/template-admin/assets/img/avatars/1.png" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
                id="uploadedAvatar" />
            <div class="button-wrapper">
                <label for="upload" class="btn btn-sm btn-primary me-3 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <i class="icon-base ri ri-upload-2-line d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                </label>
                <button type="button" class="btn btn-sm btn-outline-danger account-image-reset mb-4">
                    <i class="icon-base ri ri-refresh-line d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Reset</span>
                </button>

                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
            </div>
        </div>
    </div>

    <div class="card-body pt-0">
        <form id="formAccountSettings" method="POST" action="#">
            @csrf
            <div class="row mt-1 g-5">
                <!-- Name -->
                <div class="col-md-6 form-control-validation">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" id="name" name="name" value="John Doe" autofocus />
                        <label for="name">Name</label>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 form-control-validation">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="email" id="email" name="email"
                            value="john.doe@example.com" />
                        <label for="email">Email</label>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6 form-control-validation">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="password" id="password" name="password" placeholder="Password" />
                        <label for="password">Password</label>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                </div>

                <!-- Timestamps (readonly) -->
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" value="2025-09-22 10:00" readonly />
                        <label>Created At</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control" type="text" value="2025-09-22 12:00" readonly />
                        <label>Updated At</label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
            </div>
        </form>
    </div>
    <!-- /Account -->
</div>
@endsection
