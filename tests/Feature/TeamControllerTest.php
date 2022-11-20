<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PlayerSkill;

class TeamControllerTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $requirements =
            [
                'position' => "defender",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ];


        $res = $this->postJson(self::REQ_TEAM_URI, $requirements);

        $this->assertNotNull($res);
    }

    /** @test */
    public function user_can_select_team(){
        Player::create([
                "name" => "Dr. Cale Lueilwitz",
                "position" => "forward",
                ]
            );
        
        PlayerSkill::insert([
                [
                    "skill" => "speed",
                    "value" => 74,
                    "player_id" => 1
                ],
                [
                    "skill" => "strength",
                    "value" => 74,
                    "player_id" => 1
                ]
        ]);
        $requirements = [
                [
                    "position" => "forward",
                    "mainSkill" => "speed",
                    "numberOfPlayers" => 1
                ]
             ];



        $res = $this->postJson(self::REQ_TEAM_URI, $requirements);
        $expectedResponse = [
            [
            "name" => "Dr. Cale Lueilwitz",
            "position" => "forward",
            "playerSkills" => [
                "skill" => "speed",
                "value" => 74 
            ]
            ]
        ];

        $this->assertNotNull($res);
        $res->assertJson($expectedResponse, true);
    }
}
