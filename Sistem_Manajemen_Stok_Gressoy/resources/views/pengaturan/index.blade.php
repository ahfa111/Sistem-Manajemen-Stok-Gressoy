@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Pengaturan</h2>
            <p class="text-muted">Kelola pengaturan sistem Gressoy</p>
        </div>
    </div>

    <div class="row">
        {{-- SIDEBAR MENU --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-4 overflow-hidden">
                        <a href="#profil" class="list-group-item list-group-item-action p-3 d-flex align-items-center active" data-bs-toggle="list">
                            <i class="bi bi-person me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Profil Perusahaan</div>
                                <small class="text-muted text-white-50">Kelola info akun</small>
                            </div>
                        </a>
                        <a href="#perusahaan" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-building me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Info Perusahaan</div>
                                <small class="text-muted">Detail identitas bisnis</small>
                            </div>
                        </a>
                        <a href="#notifikasi" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-bell me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Notifikasi</div>
                                <small class="text-muted">Preferensi peringatan</small>
                            </div>
                        </a>
                        <a href="#keamanan" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-shield-lock me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Keamanan</div>
                                <small class="text-muted">Ubah password</small>
                            </div>
                        </a>
                        <a href="#users" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-people me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Kelola Pengguna</div>
                                <small class="text-muted">Manajemen user sistem</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT FORMS --}}
        <div class="col-md-9">
            <div class="tab-content">
                
                {{-- PROFIL --}}
                <div class="tab-pane fade show active" id="profil">
                    @include('pengaturan.partials.profil')
                </div>

                {{-- PERUSAHAAN --}}
                <div class="tab-pane fade" id="perusahaan">
                    @include('pengaturan.partials.perusahaan')
                </div>

                {{-- NOTIFIKASI --}}
                <div class="tab-pane fade" id="notifikasi">
                    @include('pengaturan.partials.notifikasi')
                </div>

                {{-- KEAMANAN --}}
                <div class="tab-pane fade" id="keamanan">
                    @include('pengaturan.partials.keamanan')
                </div>

                {{-- USERS --}}
                <div class="tab-pane fade" id="users">
                    @include('pengaturan.partials.users')
                </div>


            </div>
        </div>
    </div>
</div>

@include('pengaturan.partials.modal-delete')

<style>
    /* Custom Active State for Sidebar */
    .list-group-item.active {
        background-color: #fff !important;
        border-left: 4px solid #28a745 !important;
        color: #28a745 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .list-group-item.active .text-muted {
        color: #28a745 !important;
        opacity: 0.7;
    }
    .list-group-item {
        border: none;
        margin-bottom: 5px;
        border-radius: 8px !important;
        transition: all 0.2s;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .text-success { color: #2ecc71 !important; }
    .btn-success { background-color: #2ecc71; border-color: #2ecc71; }
    .btn-success:hover { background-color: #27ae60; border-color: #27ae60; }
</style>
@endsection
