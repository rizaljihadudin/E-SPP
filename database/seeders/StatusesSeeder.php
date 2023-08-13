<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 250; $i++) {
            DB::table('statuses')->insert([
                'name' => 'aktif',
                'reason' => null,
                'model_type' => 'App\Models\Siswa',
                'model_id' => fake()->randomElement(Siswa::pluck('id')->unique()->toArray())
            ]);
        }
    }
}
