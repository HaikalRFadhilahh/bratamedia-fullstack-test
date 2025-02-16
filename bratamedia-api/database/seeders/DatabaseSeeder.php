<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\GuruKelas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
        User::factory(1)->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ]);


        // Kelas
        Kelas::factory()->createMany([
            [
                'nama' => 'Kelas Informatika',

            ],
            [
                'nama' => 'Kelas Sistem Informasi'
            ]
        ]);

        // Siswa Data
        Siswa::factory()->createMany([
            [
                'nama' => "Haikal",
                'umur' => 21,
                'kelas_id' => 1
            ],
            [
                'nama' => "Ahmad",
                'umur' => 22,
                'kelas_id' => 2
            ],
            [
                'nama' => "Faishal",
                'umur' => 23,
                'kelas_id' => 2
            ]
        ]);

        // Guru Data
        Guru::factory()->createMany([
            [
                'nama' => "Adrian"
            ],
            [
                'nama' => "Zahra"
            ]
        ]);

        // Mata Pelajaran
        MataPelajaran::factory()->createMany([
            [
                'nama' => 'Algoritma Pemrograman',
                'guru_id' => 1
            ],
            [
                'nama' => 'Sistem Operasi',
                'guru_id' => 1
            ],
            [
                'nama' => 'Big Data Predictive Analytics',
                'guru_id' => 2
            ],
            [
                'nama' => 'Infrastruktur Web Dan Internet',
                'guru_id' => 2
            ],
        ]);

        // Guru kelas Data
        GuruKelas::factory()->createMany([
            [
                'kelas_id' => 1,
                'guru_id' => 1
            ],
            [
                'kelas_id' => 1,
                'guru_id' => 2
            ],
            [
                'kelas_id' => 2,
                'guru_id' => 2
            ]
        ]);
    }
}
