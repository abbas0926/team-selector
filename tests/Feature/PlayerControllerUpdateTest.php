<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;

class PlayerControllerUpdateTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $data = [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . '1', $data);

        $this->assertNotNull($res);
    }

     /** @test */
     public function user_can_update_a_player_and_his_skills(){



        $newPlayerData = [
            "name" => "New Player Name",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        Player::create($newPlayerData);

        $updatePlayerData = [
            "name" => "Updated Player Name",
            "position" => "forward",
            "playerSkills" => [
                0 => [
                    "skill" => "strength",
                    "value" => 50
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 18
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . 1, $updatePlayerData);

        $this->assertNotNull($res);

        $expectedResponse = [
            "id" => 1,
            "name" => "Updated Player Name",
            "position" => "forward",
            "playerSkills" => [
                0 => [
                    "id" => 1,
                    "skill" => "strength",
                    "value" => 50,
                    "playerId" => 1,
                ],
                1 => [
                    "id" => 2,
                    "skill" => "speed",
                    "value" => 18,
                    "playerId" => 1,
                ]
            ]
        ];

        $res->assertJson($expectedResponse, true);
    }

    /** @test */
    public function user_cant_update_player_with_invalid_value_name(){
        $data = [
            "name" => "",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . 1, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "message" => "Invalid value for name: empty"
        ];

        $res->assertJson($expectedResponse, true);
    }

    /** @test */
    public function user_cant_update_player_with_invalid_value_for_position(){
        $data = [
            "name" => "Player one",
            "position" => "wrong position",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . 1, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "message" => "Invalid value for position: wrong position"
        ];

        $res->assertJson($expectedResponse, true);
    }

     /** @test */
     public function user_cant_create_player_with_invalid_value_for_skill(){
        $data = [
            "name" => "Player one",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "wrong skill",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . 1, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "message" => "Invalid value for playerSkills.0.skill: wrong skill"
        ];

        $res->assertJson($expectedResponse, true);
    }

    /** @test */
    public function user_cant_create_player_with_invalid_value_for_skill_value(){
        $data = [
            "name" => "Player one",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "defense",
                    "value" => 'wrong value'
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . 1, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "message" => "Invalid value for playerSkills.0.value: wrong value"
        ];

        $res->assertJson($expectedResponse, true);
    }

}
