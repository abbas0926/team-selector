<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PlayerRepository{


    public function getOne($id)
    {
        return Player::where('id',$id)->with('playerSkills')->first();
    }
    public function create($data) 
    {
        return Player::create($data);
    }

    public function getAll()
    {
        return Player::with('playerSkills')->get();
    }

    public function update($id,$data)
    {
        $player=Player::find($id);
        return $player->update($data);
    }

    public function delete($id)
    {
        return Player::find($id)->delete();
    }

    public function numberOfPlayersInPosition($position)
    {
        return Player::where('position',$position)->count();
    }

    public function playersInPositionWithSkill($position,$mainSkill,$numberOfPlayers)
    {
        return DB::table('players')
        ->where('position','=',$position)
        ->join('player_skills','players.id','=','player_skills.player_id')
        ->orderByRaw(DB::raw("CASE WHEN skill = '".$mainSkill."' THEN 1 ELSE 2 END"))
        ->orderBy('player_skills.value','desc')
        ->take($numberOfPlayers)
        ->get();
    }
}

