<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use Illuminate\Database\Seeder;

class ClassLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classLevels = [
            ['name' => 'TK'],
            ['name' => 'SD Kelas 1'],
            ['name' => 'SD Kelas 2'],
            ['name' => 'SD Kelas 3'],
            ['name' => 'SD Kelas 4'],
            ['name' => 'SD Kelas 5'],
            ['name' => 'SD Kelas 6'],
            ['name' => 'SMP Kelas 7'],
            ['name' => 'SMP Kelas 8'],
            ['name' => 'SMP Kelas 9'],
            ['name' => 'SMA Kelas 10'],
            ['name' => 'SMA Kelas 11'],
            ['name' => 'SMA Kelas 12'],
            ['name' => 'Tahfidz'],
        ];

        foreach ($classLevels as $level) {
            ClassLevel::updateOrCreate(
                ['name' => $level['name']],
                $level
            );
        }
    }
}
