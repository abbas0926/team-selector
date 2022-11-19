<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Test ',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
        $accessToken = $user->createToken('API Token')->plainTextToken;
        1a8b194037ab3c2b186256623c06ba7e97667bab3a98732988a216540abd6b76

        
    }
}
