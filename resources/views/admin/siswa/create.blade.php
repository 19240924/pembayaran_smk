@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">

            {{-- HEADER CARD --}}
            <div class="card-header">
                <h3 class="card-title">Tambah Siswa Baru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            {{-- FORM TAMBAH SISWA --}}
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- ROW 1 : NIS & NAMA --}}
                    <div class="row">
                        <div class="col-md-6">
                            {{-- NIS --}}
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text"
                                       class="form-control @error('nis') is-invalid @enderror"
                                       id="nis"
                                       name="nis"
                                       value="{{ old('nis') }}"
                                       required>

                                {{-- VALIDASI ERROR --}}
                                @error('nis')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- NAMA --}}
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       id="nama"
                                       name="nama"
                                       value="{{ old('nama') }}"
                                       required>

                                @error('nama')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ROW 2 : KELAS & JURUSAN --}}
                    <div class="row">
                        <div class="col-md-6">
                            {{-- KELAS --}}
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select class="form-control @error('kelas') is-invalid @enderror"
                                        id="kelas"
                                        name="kelas"
                                        required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>

                                @error('kelas')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- JURUSAN --}}
                                <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <select class="form-control @error('jurusan') is-invalid @enderror"
                                        id="jurusan"
                                        name="jurusan"
                                        required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="TKR" {{ old('jurusan') == 'TKR' ? 'selected' : '' }}>TKR</option>
                                    <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>RPL</option>
                                    <option value="TMI" {{ old('jurusan') == 'TMI' ? 'selected' : '' }}>TMI</option>
                                </select>

                                @error('jurusan')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ROW 3 : ANGKATAN & EMAIL --}}
                    <div class="row">
                        <div class="col-md-6">
                            {{-- ANGKATAN --}}
                            <div class="form-group">
                                <label for="angkatan">Angkatan</label>
                                <input type="number"
                                       class="form-control @error('angkatan') is-invalid @enderror"
                                       id="angkatan"
                                       name="angkatan"
                                       value="{{ old('angkatan') }}"
                                       placeholder="Contoh: 2023"
                                       required>

                                @error('angkatan')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- EMAIL --}}
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
