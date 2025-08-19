<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            $bookings = Booking::with(['user', 'ruangan'])->get(); // Admin lihat semua
        } else {
            $bookings = Auth::user()->bookings()->with('ruangan')->get(); // User lihat miliknya
        }
        return view('bookings.index', compact('bookings')); // View untuk daftar booking
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        return view('bookings.create', compact('ruangans')); // View untuk form booking
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Cek konflik jadwal (overlap)
        $overlap = Booking::where('ruangan_id', $request->ruangan_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['msg' => 'Jadwal ruangan sudah booked!']);
        }

        Booking::create([
            'user_id' => Auth::id(),
            'ruangan_id' => $request->ruangan_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil.');
    }
}