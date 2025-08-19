<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('ruangans.index', compact('ruangans')); // View untuk daftar ruangan
    }

    public function create()
    {
        return view('ruangans.create'); // View untuk form tambah ruangan
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Ruangan::create($request->all());
        return redirect()->route('ruangans.index')->with('success', 'Ruangan ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('ruangans.edit', compact('ruangan')); // View untuk edit
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $ruangan->update($request->all());
        return redirect()->route('ruangans.index')->with('success', 'Ruangan diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangans.index')->with('success', 'Ruangan dihapus.');
    }
}