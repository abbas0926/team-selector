<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW. 
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property PlayerPosition $position
 * @property PlayerSkill $skill
 */
class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position'
    ];
    
    public function playerSkills(){
        return $this->hasMany(PlayerSkill::class);
    }
}
