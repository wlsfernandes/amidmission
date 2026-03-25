<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Sector::insert([
      ['key' => 'founders', 'name' => 'Founders Strategic Council'],
      ['key' => 'board', 'name' => 'Board of Advisors'],
      ['key' => 'faculty', 'name' => 'Faculty'],
      ['key' => 'staff', 'name' => 'Our Staff'],
    ]);
    $this->command->info('✅ Sector users created:');
  }
}
