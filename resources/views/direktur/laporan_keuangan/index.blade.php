@extends('layout.direktur-template')

@section('title', 'Laporan Keuangan')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-6">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body text-nowrap">
                        <h5 class="card-title mb-0 flex-wrap text-nowrap">Congratulations Norris! 🎉</h5>
                        <p class="mb-2">Best seller of the month</p>
                        <h4 class="text-primary mb-0">$42.8k</h4>
                        <p class="mb-2">78% of target 🚀</p>
                        <a href="javascript:;" class="btn btn-sm btn-primary">View Sales</a>
                    </div>
                    <img src="../assets/img/illustrations/trophy.png" class="position-absolute bottom-0 end-0 me-5 mb-5"
                        width="83" alt="view sales" />
                </div>
            </div>
            <!--/ Congratulations card -->

            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Transactions</h5>
                            <div class="dropdown">
                                <button class="btn text-body-secondary p-0" type="button" id="transactionID"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                </div>
                            </div>
                        </div>
                        <p class="small mb-0"><span class="h6 mb-0">Total 48.5% Growth</span> 😎 this month</p>
                    </div>
                    <div class="card-body pt-lg-10">
                        <div class="row g-6">
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-primary rounded shadow-xs">
                                            <i class="icon-base ri ri-pie-chart-2-line icon-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0">Sales</p>
                                        <h5 class="mb-0">245k</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-success rounded shadow-xs">
                                            <i class="icon-base ri ri-group-line icon-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0">Customers</p>
                                        <h5 class="mb-0">12.5k</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-warning rounded shadow-xs">
                                            <i class="icon-base ri ri-macbook-line icon-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0">Product</p>
                                        <h5 class="mb-0">1.54k</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-info rounded shadow-xs">
                                            <i class="icon-base ri ri-money-dollar-circle-line icon-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0">Revenue</p>
                                        <h5 class="mb-0">$88k</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Data Tables -->
            <div class="col-12">
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
                                                <img src="../assets/img/avatars/1.png" alt="Avatar"
                                                    class="rounded-circle" />
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/3.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Benedetto Rossiter</h6>
                                                <small class="text-truncate">@brossiter15</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">estelle.Bailey10@gmail.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-edit-box-line text-warning icon-22px me-2"></i>
                                            <span>Editor</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/2.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Bentlee Emblin</h6>
                                                <small class="text-truncate">@bemblinf</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">milo86@hotmail.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-computer-line text-danger icon-22px me-2"></i>
                                            <span>Author</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/5.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Bertha Biner</h6>
                                                <small class="text-truncate">@bbinerh</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">lonnie35@hotmail.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-edit-box-line text-warning icon-22px me-2"></i>
                                            <span>Editor</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-warning rounded-pill">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/4.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Beverlie Krabbe</h6>
                                                <small class="text-truncate">@bkrabbe1d</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">ahmad_Collins@yahoo.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-pie-chart-2-line icon-22px text-info me-2"></i>
                                            <span>Maintainer</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/7.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Bradan Rosebotham</h6>
                                                <small class="text-truncate">@brosebothamz</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">tillman.Gleason68@hotmail.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-edit-box-line text-warning icon-22px me-2"></i>
                                            <span>Editor</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-warning rounded-pill">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/6.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Bree Kilday</h6>
                                                <small class="text-truncate">@bkildayr</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">otho21@gmail.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-user-3-line icon-22px text-success me-2"></i>
                                            <span>Subscriber</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-success rounded-pill">Active</span></td>
                                </tr>
                                <tr class="border-transparent">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/1.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">Breena Gallemore</h6>
                                                <small class="text-truncate">@bgallemore6</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">florencio.Little@hotmail.com</td>
                                    <td class="text-truncate">
                                        <div class="d-flex align-items-center">
                                            <i class="icon-base ri ri-user-3-line icon-22px text-success me-2"></i>
                                            <span>Subscriber</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-secondary rounded-pill">Inactive</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Data Tables -->
        </div>
    </div>
@endsection
