<?php

use App\Profile;
use App\User;
use Illuminate\Database\Seeder;

class MembroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 10)->create()->each(function ($user) {
            $profile = factory(Profile::class, 1)->create([
                'user_id' => $user->id,
                'state_id' => 19,
                'city_id' => 3185,
            ]);
        });
    }
}
