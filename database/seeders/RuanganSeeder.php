<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        Ruangan::create([
            'nama_ruangan' => 'Ruang Rapat A',
            'deskripsi' => 'Kapasitas 10 orang',
        ]);
        Ruangan::create([
            'nama_ruangan' => 'Ruang Seminar',
            'deskripsi' => 'Kapasitas 50 orang',
        ]);
    }
}