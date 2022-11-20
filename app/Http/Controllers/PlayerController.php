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
use App\Services\PlayerService;
use App\Services\PlayerSkillService;
use Illuminate\Http\Request;

class PlayerController extends Controller
{

    private $playerService;
    private $playerSkillService;

    public function __construct(PlayerService $playerService, PlayerSkillService $playerSkillService)
    {
        $this->playerService = $playerService;
        $this->playerSkillService = $playerSkillService;

    }

    public function index()
    {
        try {

            $players=$this->playerService->getAll();
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

            $player=$this->playerService->create($request->only('name','position'));
            $skills=$request->playerSkills;
            $this->playerSkillService->insert($skills,$player);
            $result=$this->playerService->getOne($player->id);

            return new PlayerResource($result);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
       
    }

    public function update($id,UpdatePlayerRequest $request)
    {
        try {
            
            $this->playerService->update($id,$request->only('name','position'));
            $this->playerSkillService->updateOrCreate($request->playerSkills,$id);
            $result=$this->playerService->getOne($id);

            return new PlayerResource($result);

        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
    }

    public function destroy($id, Request $request)
    {
        try {
            $token = $request->bearerToken();
            //This solution was not implemented in a proper way using JWT tokens due to lack of time, best regards.
            if($token!="SkFabTZibXE1aE14ckpQUUxHc2dnQ2RzdlFRTTM2NFE2cGI4d3RQNjZmdEFITmdBQkE="){
                return response("Unauthenticated", 401);
            }

            $this->playerService->delete($id);
            return response(["message" => "success"],200);
            
        } catch (\Throwable $th) {
            throw $th;
        }

        return response("Failed", 500);
    }
}
