<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlayerSkill>
 */
class PlayerSkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'skill'=>$this->faker->randomElement(['defense','attack','speed','strength','stamina']),
            'value'=>$this->faker->numberBetween($min=10,$max=100),
            'player_id' => Player::pluck('id')[$this->faker->numberBetween(1,Player::count()-1)]
        ];
    }
}
