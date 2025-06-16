@extends('layouts.pesan')

@section('content')
<div class="container mt-5">
    <h3>Langkah 3: Konfirmasi & Pembayaran</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3>Langkah 3: Konfirmasi & Pembayaran</h3>
    <p><strong>Tanggal Booking:</strong> {{ $bookingDate }}</p>
    <p><strong>Jam Booking:</strong> {{ $bookingTime }}</p>
    <p><strong>Jenis Kendaraan:</strong> {{ ucfirst($vehicleType) }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($price, 0, ',', '.') }}</p>

    <form method="POST" action="{{ route('booking.step3') }}">
        @csrf
        <input type="hidden" name="booking_date" value="{{ $bookingDate }}">
        <input type="hidden" name="booking_time" value="{{ $bookingTime }}">
        <input type="hidden" name="vehicle_type" value="{{ $vehicleType }}">
        

        <div class="form-group">
            <label for="payment_method">Metode Pembayaran:</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="">-- Pilih metode pembayaran --</option>
                <option value="cash">Bayar di Tempat</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Selesaikan Pemesanan</button>
    </form>

</div>
@endsection
