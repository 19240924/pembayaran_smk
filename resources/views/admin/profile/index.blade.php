@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <h4 class="mb-4">Pengaturan Profil</h4>

    <!-- Alert sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        <!-- =========================
             INFORMASI PROFIL
        ========================== -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-person-circle me-1"></i>
                    Informasi Profil
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Role (Readonly) -->
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ ucfirst($user->role) }}"
                                   readonly>
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- =========================
             UBAH PASSWORD
        ========================== -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning">
                    <i class="bi bi-lock-fill me-1"></i>
                    Ubah Password
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Password Lama -->
                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password"
                                   name="old_password"
                                   class="form-control @error('old_password') is-invalid @enderror">

                            @error('old_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control">
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-shield-lock me-1"></i>
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
