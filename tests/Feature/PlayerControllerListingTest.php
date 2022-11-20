<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PlayerSkill;
use Database\Seeders\PlayerSkillSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class PlayerControllerListingTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $res = $this->get(self::REQ_URI);
        $this->assertNotNull($res);
    }

    /** @test */
    public function user_can_list_all_players()
    {
        $players=Player::insert([
            [
                "name"=> "Durward Kihn",
                "position"=> "forward",
            ],
            [
                "name"=> "Melyssa Metz V",
                "position"=> "defender",
            ]
            ]);

         PlayerSkill::insert([
            [
                "skill"=> "defense",
                "value"=> 58,
                "player_id"=> 1
            ],
            [
                "skill"=> "attack",
                "value"=> 77,
                "player_id"=> 1
            ],
            [
                "skill"=> "strength",
                "value"=> 88,
                "player_id"=> 2
            ],
            [
                "skill"=> "speed",
                "value"=> 27,
                "player_id"=> 2
            ]
        ]);
          
        $res = $this->getJson(self::REQ_URI);

        $this->assertNotNull($res);

        $expectedResponse = [
            
                [
                    "id"=> 1,
                    "name"=> "Durward Kihn",
                    "position"=> "forward",
                    "playerSkills"=> [
                        [   
                            "id" => 1,
                            "skill"=> "defense",
                            "value"=> 58,
                            "playerId"=> 1
                        ],
                        [
                            "id" => 2,
                            "skill"=> "attack",
                            "value"=> 77,
                            "playerId"=> 1
                        ]
                    ]
                ],
                [
                    "id"=> 2,
                    "name"=> "Melyssa Metz V",
                    "position"=> "defender",
                    "playerSkills"=> [
                        [
                            "id" => 3,
                            "skill"=> "strength",
                            "value"=> 88,
                            "playerId"=> 2
                        ],
                        [
                            "id" => 4,
                            "skill"=> "speed",
                            "value"=> 27,
                            "playerId"=> 2
                        ]
                    ]
                ]
        ];
          
        $res->assertJson($expectedResponse, true);
        
    }

}