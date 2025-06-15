@extends('layouts.index')
@extends('administrator.sidebar')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-uppercase font-weight-bold">Edit Pengguna</h2>

        <!-- Menampilkan pesan error atau sukses -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @elseif(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Edit Pengguna -->
        <form action="{{ url('/admin/users/'.$user['id']) }}" method="POST" class="shadow p-4 rounded-lg bg-light">
            @csrf
            @method('PUT') <!-- Menggunakan method PUT untuk update -->

            <div class="row mb-3">
                <label for="name" class="col-sm-3 col-form-label font-weight-semibold">Nama:</label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{ $user['name'] }}" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label font-weight-semibold">Email:</label>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ $user['email'] }}" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="role" class="col-sm-3 col-form-label font-weight-semibold">Role:</label>
                <div class="col-sm-9">
                    <select name="role" id="role" class="form-select form-select-lg" required>
                        <option value="Tim Keuangan" {{ $user['role'] == 'Tim Keuangan' ? 'selected' : '' }}>Tim Keuangan</option>
                        <option value="panitia pelaksana kegiatan" {{ $user['role'] == 'panitia pelaksana kegiatan' ? 'selected' : '' }}>Panitia Pelaksana Kegiatan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="status" class="col-sm-3 col-form-label font-weight-semibold">Status:</label>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-select form-select-lg" required>
                        <option value="ACTIVE" {{ $user['status'] == 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                        <option value="INACTIVE" {{ $user['status'] == 'INACTIVE' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-9 text-center">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Perbarui Pengguna</button>
                </div>
            </div>
        </form>
    </div>
@endsection
