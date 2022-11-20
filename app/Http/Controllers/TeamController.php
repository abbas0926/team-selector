<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamSelectionRequest;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\SelectedPlayerCollection;
use App\Http\Resources\SelectedPlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    private $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function process(TeamSelectionRequest $request){

        try {
            $result=[];
            foreach ($request->request as $key => $value) {
            $availablePlayersForPosition=$this->playerService
            ->numberOfPlayersInPosition($value['position']);
            
            if($availablePlayersForPosition<$value['numberOfPlayers']){
                return response(["message"=>"Insufficient number of players for position: ".$value['position']], 400);
            }
            
            $playersInPositionWithSkill=$this->playerService
            ->playersInPositionWithSkill($value['position'],$value['mainSkill'],$value['numberOfPlayers']);
            
            $players= array_map(function($element) {
                return [
                    'name' => $element->name,
                    'position' =>$element->position,
                    'playerSkills'=>[
                        'skill'=>$element->skill,
                        'value' =>$element->value,
                    ],
                ];
            }, $playersInPositionWithSkill->toArray());

            $result=array_merge($result,$players);
         
           }
            return response($result);

        } catch (\Throwable $th) {
            throw $th;
        }
        
        return response("Failed", 500);
    }
}
