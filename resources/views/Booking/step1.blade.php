@extends('layouts.pesan')

@section('content')
<div class="container">
    <h2>Pilih Tanggal & Jam</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/booking/step1') }}">
        @csrf

        <!-- Pilih tanggal -->
        <div class="mb-3">
            <label for="booking_date" class="form-label">Tanggal</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
        </div>

        <!-- Pilih jam -->
        <div class="mb-3">
            <label for="booking_time" class="form-label">Jam</label>
            <select name="booking_time" id="booking_time" class="form-select" required>
                <option value="">-- Pilih jam --</option>
                <!-- Akan diisi lewat JavaScript -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lanjut</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('booking_date').addEventListener('change', function () {
        const date = this.value;
        const timeSelect = document.getElementById('booking_time');

        // Clear existing options
        timeSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/available-times?date=${date}`)
            .then(response => response.json())
            .then(data => {
                timeSelect.innerHTML = '';

                if (data.length === 0) {
                    timeSelect.innerHTML = '<option value="">Semua jam penuh</option>';
                } else {
                    timeSelect.innerHTML = '<option value="">-- Pilih jam --</option>';
                    data.forEach(time => {
                        timeSelect.innerHTML += `<option value="${time}">${time}</option>`;
                    });
                }
            });
    });
</script>
@endsection
