@extends('layout.direktur-template')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Jobdesk</h5>
            <small class="text-body-secondary float-end">Form Tambah Data Jobdesk</small>
        </div>
        <div class="card-body">
            <form>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Jobdesk</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text">
                                <i class="icon-base ri ri-task-line"></i>
                            </span>
                            <input type="text" class="form-control" id="basic-icon-default-fullname"
                                placeholder="Masukkan Judul Jobdesk" aria-label="Jobdesk"
                                aria-describedby="basic-icon-default-fullname2" />
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Deskripsi</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text">
                                <i class="icon-base ri ri-file-text-line"></i>
                            </span>
                            <input type="text" id="basic-icon-default-company" class="form-control"
                                placeholder="Masukkan Deskripsi Jobdesk" aria-label="Deskripsi"
                                aria-describedby="basic-icon-default-company2" />
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Divisi</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">
                                <i class="icon-base ri ri-group-line"></i>
                            </span>
                            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                <option selected="selected">Pilih Divisi</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <a href="/direktur/jobdesk" type="submit" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
