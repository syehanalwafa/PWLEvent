@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Tim Keuangan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(isset($payments) && count($payments) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Peserta</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $p)
                <tr>
                    <td>{{ $p['name'] ?? 'Unknown' }}</td>
                    <td>{{ $p['event_name'] ?? '-' }}</td>
                    <td><span class="badge bg-{{ $p['payment_status'] === 'verified' ? 'success' : ($p['payment_status'] === 'rejected' ? 'danger' : 'secondary') }}">{{ $p['payment_status'] }}</span></td>
                    <td>
                        @if($p['payment_proof'])
                            <a href="{{ asset('uploads/' . $p['payment_proof']) }}" target="_blank">Lihat Bukti</a>
                        @else
                            Tidak ada
                        @endif
                    </td>
                    <td>
                        @if($p['payment_status'] === 'pending')
                            <form method="POST" action="{{ route('keuangan.verify', $p['registration_id']) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Verifikasi</button>
                            </form>
                            <form method="POST" action="{{ route('keuangan.reject', $p['registration_id']) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada data pembayaran.</p>
    @endif
</div>
@endsection