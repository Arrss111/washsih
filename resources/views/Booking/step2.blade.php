@extends('layouts.pesan')

@section('content')
<div class="container mt-5">
    <h3>Langkah 2: Pilih Jenis Kendaraan</h3>
    <p><strong>Tanggal Booking:</strong> {{ $bookingDate }}</p>
    <p><strong>Jam Booking:</strong> {{ $bookingTime }}</p>

    <form method="POST" action="{{ route('booking.step2') }}">
        @csrf
        <label>Pilih Jenis Kendaraan:</label><br>
        <input type="radio" name="vehicle_type" value="motor" required> Motor (Rp 15.000)<br>
        <input type="radio" name="vehicle_type" value="mobil" required> Mobil (Rp 25.000)<br>
        <button type="submit">Lanjut ke Step 3</button>
    </form>

</div>
@endsection
