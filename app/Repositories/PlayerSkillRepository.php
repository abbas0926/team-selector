<?php

namespace App\Repositories;

use App\Models\PlayerSkill;

class PlayerSkillRepository{

    public function insert($data) 
    {
        return PlayerSkill::insert($data);
    }

    public function updateOrCreate($player,$skill)
    {
        PlayerSkill::updateOrCreate($player,$skill);
    }
}