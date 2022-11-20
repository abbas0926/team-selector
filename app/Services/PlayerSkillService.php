<?php

 namespace App\Services;

use App\Repositories\PlayerSkillRepository;

class PlayerSkillService {
    private $playerSkillRepo;    


    public function __construct(PlayerSkillRepository $playerSkillRepo)
    {
        $this->playerSkillRepo = $playerSkillRepo;
    }

    public function insert($data,$player)
    {
        $skills= array_map(function($element) use($player){
            return [
                'skill' => $element['skill'],
                'value' =>$element['value'],
                'player_id'=>$player->id,
            ];
        }, $data);
     return $this->playerSkillRepo->insert($skills); 
    }

    public function updateOrCreate($data,$id)
    {
        foreach ($data as $playerSkill) {
            $this->playerSkillRepo->updateOrCreate(['player_id' => $id,'skill' => $playerSkill['skill']],['value' => $playerSkill['value']]);
        }
    }
}