<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function bookings()
    {
        $bookings = Booking::with('user')->orderByDesc('booking_date')->get();
        return view('admin.bookings', compact('bookings'));
    }
}
