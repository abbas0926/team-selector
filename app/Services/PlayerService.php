<?php

namespace App\Services;

use App\Repositories\PlayerRepository;

class PlayerService {

    private $playerRepo;    


    public function __construct(PlayerRepository $playerRepo)
    {
        $this->playerRepo = $playerRepo;
    }
    
    public function getOne($id)
    {
        return $this->playerRepo->getOne($id);
    }
    public function getAll()
    {
        return $this->playerRepo->getAll();
    }

    public function create($data)
    {
        return $this->playerRepo->create($data);
    }

    public function update($id,$data)
    {
        return $this->playerRepo->update($id,$data);
    }

    public function delete($id)
    {
        return $this->playerRepo->delete($id);
    }

    public function numberOfPlayersInPosition($position)
    {
        return $this->playerRepo->numberOfPlayersInPosition($position);
    }
    public function playersInPositionWithSkill($position,$mainSkill,$numberOfPlayers)
    {
        return $this->playerRepo->playersInPositionWithSkill($position,$mainSkill,$numberOfPlayers);
    }
}