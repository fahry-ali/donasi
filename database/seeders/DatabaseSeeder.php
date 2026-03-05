<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriProgram;
use App\Models\ProgramDonasi;
use App\Models\KontenKegiatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'nama' => 'Admin Panti',
            'email' => 'admin@pantiasuhan.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Masyarakat User
        User::create([
            'nama' => 'User Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'masyarakat',
        ]);

        // Create Sample Donatur User
        User::create([
            'nama' => 'Donatur Demo',
            'email' => 'donatur@example.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'donatur',
        ]);

        // Create Kategori Program
        $kategoriPendidikan = KategoriProgram::create(['nama_kategori' => 'Pendidikan']);
        $kategoriKesehatan = KategoriProgram::create(['nama_kategori' => 'Kesehatan']);
        $kategoriBangunan = KategoriProgram::create(['nama_kategori' => 'Renovasi Bangunan']);
        $kategoriKebutuhan = KategoriProgram::create(['nama_kategori' => 'Kebutuhan Sehari-hari']);
        $kategoriKegiatan = KategoriProgram::create(['nama_kategori' => 'Kegiatan & Event']);

        // Create Sample Programs
        ProgramDonasi::create([
            'id_kategori' => $kategoriPendidikan->id_kategori,
            'judul_program' => 'Beasiswa Anak Panti 2024',
            'deskripsi' => 'Program beasiswa untuk mendukung pendidikan anak-anak panti asuhan dari tingkat SD hingga SMA. Dana akan digunakan untuk biaya sekolah, buku, dan perlengkapan belajar.',
            'target_dana' => 50000000,
            'dana_terkumpul' => 15000000,
            'status_program' => 'aktif',
            'sumber_program' => 'yayasan',
            'created_by' => $admin->id_user,
        ]);

        ProgramDonasi::create([
            'id_kategori' => $kategoriBangunan->id_kategori,
            'judul_program' => 'Renovasi Aula Panti',
            'deskripsi' => 'Program renovasi aula panti yang sudah tidak layak. Aula digunakan untuk berbagai kegiatan anak-anak termasuk belajar, bermain, dan acara-acara penting.',
            'target_dana' => 75000000,
            'dana_terkumpul' => 25000000,
            'status_program' => 'aktif',
            'sumber_program' => 'yayasan',
            'created_by' => $admin->id_user,
        ]);

        ProgramDonasi::create([
            'id_kategori' => $kategoriKesehatan->id_kategori,
            'judul_program' => 'Pemeriksaan Kesehatan Rutin',
            'deskripsi' => 'Program pemeriksaan kesehatan rutin untuk seluruh penghuni panti asuhan. Meliputi pemeriksaan umum, gigi, mata, dan vaksinasi.',
            'target_dana' => 20000000,
            'dana_terkumpul' => 5000000,
            'status_program' => 'aktif',
            'sumber_program' => 'yayasan',
            'created_by' => $admin->id_user,
        ]);

        ProgramDonasi::create([
            'id_kategori' => $kategoriKebutuhan->id_kategori,
            'judul_program' => 'Kebutuhan Dapur Bulan Ini',
            'deskripsi' => 'Program pemenuhan kebutuhan dapur untuk 50 anak panti selama satu bulan. Termasuk beras, lauk pauk, sayuran, dan keperluan dapur lainnya.',
            'target_dana' => 15000000,
            'dana_terkumpul' => 8000000,
            'status_program' => 'aktif',
            'sumber_program' => 'yayasan',
            'created_by' => $admin->id_user,
        ]);

        // Create Sample Konten Kegiatan
        KontenKegiatan::create([
            'judul' => 'Peringatan Hari Kemerdekaan',
            'deskripsi' => 'Anak-anak panti asuhan turut memeriahkan Hari Kemerdekaan RI dengan berbagai lomba dan kegiatan menarik. Terima kasih kepada para donatur yang telah mendukung acara ini.',
            'created_by' => $admin->id_user,
        ]);

        KontenKegiatan::create([
            'judul' => 'Kunjungan dari Komunitas Peduli',
            'deskripsi' => 'Kami menerima kunjungan dari komunitas peduli anak yang memberikan donasi berupa buku pelajaran dan alat tulis untuk anak-anak panti.',
            'created_by' => $admin->id_user,
        ]);

        KontenKegiatan::create([
            'judul' => 'Buka Puasa Bersama',
            'deskripsi' => 'Kegiatan buka puasa bersama yang dihadiri oleh pengurus, anak-anak panti, dan para donatur tetap. Momen kebersamaan yang penuh berkah.',
            'created_by' => $admin->id_user,
        ]);
    }
}
