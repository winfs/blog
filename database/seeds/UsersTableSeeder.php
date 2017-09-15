<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'childelins@gmail.com',
                'password' => Hash::make('lx123456'),
                'status' => true,
                'is_admin' => true,
                'confirm_code' => str_random(64),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        ];

        DB::table('users')->insert($users);

        factory(User::class, 10)->create();
    }
}
