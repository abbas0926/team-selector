<?php

namespace Database\Seeders;

use App\Models\PlayerSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playerSkills = PlayerSkill::factory()->count(50)->make();

        foreach ($playerSkills as $playerSkill) {
           
            try {
                $playerSkill->save();
            } catch (\Throwable $th) {
                continue;
            }
        }
    }
}
