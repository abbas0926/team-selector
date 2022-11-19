<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW. 
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Models\PlayerSkill;

class PlayerController extends Controller
{
    public function index()
    {
        try {

            $players=Player::with('playerSkills')->get();
            return new PlayerCollection($players);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
    }

    public function show()
    {
        return response("Failed", 500);
    }

    public function store(CreatePlayerRequest $request)
    {
        try {
            $player=Player::create($request->only('name','position'));
            $skills=$request->playerSkills;

            $skills= array_map(function($element) use($player){
                return [
                    'skill' => $element['skill'],
                    'value' =>$element['value'],
                    'player_id'=>$player->id,
                ];
            }, $skills);

            PlayerSkill::insert($skills);

            $result=Player::where('id',$player->id)->with('playerSkills')->first();
            return new PlayerResource($result);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
       
    }

    public function update($id,UpdatePlayerRequest $request)
    {
        try {

            $player=Player::find($id);
            $player->update($request->only('name','position'));
            $player->save();

            foreach ($request->playerSkills as $playerSkill) {
                PlayerSkill::updateOrCreate(['player_id' => $player->id,'skill' => $playerSkill['skill']],['value' => $playerSkill['value']]);
            }

            $result=Player::where('id',$player->id)->with('playerSkills')->first();
            return new PlayerResource($result);

        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
    }

    public function destroy($id)
    {
        try {

            $player=Player::find($id);
            $player->delete();
            return response([],200);
            
        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
    }
}
