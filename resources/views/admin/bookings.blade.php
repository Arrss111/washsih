<x-app-layout>

<div class="container">
    <h2>Daftar Booking</h2>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Kendaraan</th>
                <th>Harga</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ $booking->booking_time }}</td>
                    <td>{{ ucfirst($booking->vehicle_type) }}</td>
                    <td>Rp{{ number_format($booking->price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($booking->payment_method) }}</td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada data booking.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-app-layout>
