<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\Saran;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    User::factory()->create([
      'nama_lengkap' => 'Test Admin',
      'username' => 'eki',
      'role' => 'admin',
      'sebagai' => 'staff',
      'status' => '1',
    ]);

    User::factory()->create([
      'nama_lengkap' => 'Test User',
      'username' => 'user',
      'role' => 'user',
      'sebagai' => 'ortu',
      'status' => '1',
      'password' => '#123Password',
    ]);

    User::factory()->create([
      'nama_lengkap' => 'Test Wali',
      'username' => 'wali',
      'role' => 'user',
      'sebagai' => 'wali',
      'status' => '0',
    ]);

    Saran::factory(1)->create();
    Kegiatan::factory(1)->create();
  }
}
