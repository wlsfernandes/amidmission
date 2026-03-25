<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Sector;
use Illuminate\Support\Facades\DB;

class TeamSectorMigrationSeeder extends Seeder
{
  public function run(): void
  {
    $this->command->info('Migrating legacy team.sector values to sector_team pivot...');

    // Load all sectors indexed by key (founders, board, faculty, staff)
    $sectors = Sector::all()->keyBy('key');

    if ($sectors->isEmpty()) {
      $this->command->error('No sectors found. Run SectorSeeder first.');
      return;
    }

    Team::whereNotNull('sector')->chunk(50, function ($teams) use ($sectors) {
      foreach ($teams as $team) {

        $legacyKey = trim($team->sector);

        if (!$legacyKey) {
          continue;
        }

        if (!isset($sectors[$legacyKey])) {
          $this->command->warn("Unknown sector '{$legacyKey}' for team ID {$team->id}");
          continue;
        }

        $sectorId = $sectors[$legacyKey]->id;

        // Attach without duplicates
        DB::table('sector_team')->updateOrInsert(
          [
            'team_id' => $team->id,
            'sector_id' => $sectorId,
          ],
          []
        );
      }
    });

    $this->command->info('✔ Team → Sector migration completed successfully.');
  }
}
