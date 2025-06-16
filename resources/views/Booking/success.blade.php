@extends('layouts.pesan') 

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body text-center">
            <h2 class="text-success">Booking Berhasil!</h2>
            <p class="mt-3">Terima kasih, pesanan cuci kendaraan Anda telah tercatat.</p>

            <a href="{{ route('booking.step1') }}" class="btn btn-primary mt-4">
                Buat Booking Baru
            </a>
        </div>
    </div>
</div>
@endsection
