<?php


// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;

class PlayerControllerCreateTest extends PlayerControllerBaseTest
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

        $res = $this->postJson(self::REQ_URI, $data);
        $this->assertNotNull($res);
    }

      /** @test */
    public function user_can_create_player_with_player_skills(){
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

        $res = $this->postJson(self::REQ_URI, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "id" => 1,
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "id" => 1,
                    "skill" => "attack",
                    "value" => 60,
                    "playerId" => 1,
                ],
                1 => [
                    "id" => 2,
                    "skill" => "speed",
                    "value" => 80,
                    "playerId" => 1,
                ]
            ]
        ];

        $res->assertJson($expectedResponse, true);
    }


    /** @test */
    public function user_cant_create_player_with_invalid_name_field(){
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

        $res = $this->postJson(self::REQ_URI, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "message" => "Invalid value for name: empty"
        ];

        $res->assertJson($expectedResponse, true);
    }

    /** @test */
    public function user_cant_create_player_with_invalid_value_for_position_field(){
        $data = [
            "name" => "Player one",
            "position" => "post",
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

        $res = $this->postJson(self::REQ_URI, $data);

        $this->assertNotNull($res);

        $expectedResponse = [
            "message" => "Invalid value for position: post"
        ];

        $res->assertJson($expectedResponse, true);
    }
}
