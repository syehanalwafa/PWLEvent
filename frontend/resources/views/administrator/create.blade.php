@extends('layouts.index')
@extends('administrator.sidebar')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-uppercase font-weight-bold">Tambah Pengguna</h2>

        <form action="{{ url('/admin/users') }}" method="POST" class="shadow p-4 rounded-lg bg-light">
            @csrf
            <div class="row mb-3">
                <label for="name" class="col-sm-3 col-form-label font-weight-semibold">Nama:</label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label font-weight-semibold">Email:</label>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-sm-3 col-form-label font-weight-semibold">Password:</label>
                <div class="col-sm-9">
                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Masukkan password" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="role" class="col-sm-3 col-form-label font-weight-semibold">Role:</label>
                <div class="col-sm-9">
                    <select name="role" id="role" class="form-select form-select-lg" required>
                        <option value="Tim Keuangan">Tim Keuangan</option>
                        <option value="panitia pelaksana kegiatan">Panitia Kegiatan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="status" class="col-sm-3 col-form-label font-weight-semibold">Status:</label>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-select form-select-lg" required>
                        <option value="ACTIVE">Aktif</option>
                        <option value="INACTIVE">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-9 text-center">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Tambah Pengguna</button>
                </div>
            </div>
        </form>
    </div>
@endsection
