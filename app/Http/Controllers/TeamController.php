<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamSelectionRequest;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\SelectedPlayerCollection;
use App\Http\Resources\SelectedPlayerResource;
use App\Models\Player;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function process(TeamSelectionRequest $request){

        try {
            $result=[];
            foreach ($request->request as $key => $value) {
            $availablePlayersForPosition=Player::where('position',$value['position'])->count();
            
            if($availablePlayersForPosition<$value['numberOfPlayers']){
                return response(["message"=>"Insufficient number of players for position: ".$value['position']], 400);
            }
            
            $playersInPositionWithSkill=DB::table('players')
                ->where('position','=',$value['position'])
                ->join('player_skills','players.id','=','player_skills.player_id')
                ->orderByRaw(DB::raw("CASE WHEN skill = '".$value['mainSkill']."' THEN 1 ELSE 2 END"))
                ->orderBy('player_skills.value','desc')
                ->take($value['numberOfPlayers'])
                ->get();
            
            
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
