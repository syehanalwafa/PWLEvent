    {{-- resources/views/administrator/admin.blade.php --}}
    @extends('layouts.index')
    @extends('administrator.sidebar')

    @section('content')
        <h1>Selamat datang, {{ session('name') }}</h1>

        <!-- Tabel Pengguna -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filteredUsers as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['role'] }}</td>
                        <td>{{ $user['status'] }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ url('/admin/users/'.$user['id'].'/edit') }}" class="btn btn-warning">Edit</a>

                            <!-- Tombol Hapus -->
                            <form action="{{ url('/admin/users/'.$user['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>

                            <!-- Tombol Nonaktifkan -->
                            @if($user['status'] == 'ACTIVE')
                                <form action="{{ url('/admin/users/'.$user['id'].'/deactivate') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">Nonaktifkan</button>
                                </form>
                            @else
                                <!-- Tombol Aktifkan Kembali -->
                                <form action="{{ url('/admin/users/'.$user['id'].'/activate') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Aktifkan Kembali</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
