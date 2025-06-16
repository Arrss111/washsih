<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;


class BookingController extends Controller
{
    public function step1()
    {
        return view('booking.step1');
    }

    public function availableTimes(Request $request)
    {
        $bookedTimes = Booking::where('booking_date', $request->date)
                            ->pluck('booking_time')
                            ->toArray();

        $allTimes = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00'];

        $available = array_filter($allTimes, fn($time) => !in_array($time, $bookedTimes));

        return response()->json(array_values($available));
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        session([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
        ]);

        return redirect()->route('booking.step2');
    }

    public function step2()
    {
    $bookingDate = session('booking_date');
    $bookingTime = session('booking_time');
    $price = session('vehicle_type') == 'motor' ? 15000 : 25000;

    // Jika tidak ada di session, redirect kembali ke step1
    if (!$bookingDate || !$bookingTime) {
        return redirect()->route('booking.step1')->with('error', 'Silakan pilih tanggal dan jam terlebih dahulu.');
    }

    return view('booking.step2', compact('bookingDate', 'bookingTime'));
    }

    public function storeStep2(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|in:motor,mobil',
        ]);

        // Hitung harga berdasarkan tipe kendaraan
        $price = $request->vehicle_type == 'motor' ? 15000 : 25000;

        // Simpan ke session
        session([
            'vehicle_type' => $request->vehicle_type,
            'price' => $price,
        ]);

        return redirect()->route('booking.step3');
    }

    public function step3()
    {
        $bookingDate = session('booking_date');
        $bookingTime = session('booking_time');
        $vehicleType = session('vehicle_type');


        if (!$bookingDate || !$bookingTime || !$vehicleType) {
            return redirect()->route('booking.step1')->with('error', 'Data booking tidak lengkap.');
        }

        $price = $vehicleType == 'motor' ? 15000 : 25000;

        session(['price' => $price]);

        return view('booking.step3', compact('bookingDate', 'bookingTime', 'vehicleType', 'price'));
    }


    public function storeStep3(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $date = session('booking_date');
        $time = session('booking_time');
        $vehicleType = session('vehicle_type');
        $price = session('price'); // ambil dari session, bukan dihitung ulang

        if (!$date || !$time || !$vehicleType || !$price) {
            return redirect()->route('booking.step1')->with('error', 'Data booking tidak lengkap.');
        }

        $exists = Booking::where('booking_date', $date)
                        ->where('booking_time', $time)
                        ->first();

        if ($exists) {
            return redirect()->route('booking.step1')->with('error', 'Waktu sudah diambil orang lain.');
        }

        Booking::create([
            'user_id' => auth()->id(),
            'booking_date' => $date,
            'booking_time' => $time,
            'vehicle_type' => $vehicleType,
            'price' => $price,
            'payment_method' => $request->payment_method,
        ]);

        session()->forget(['booking_date', 'booking_time', 'vehicle_type', 'price']);

        return redirect()->route('booking.success')->with('success', 'Booking berhasil!');

    }

    public function success()
    {
        return view('booking.success');
    }



}
