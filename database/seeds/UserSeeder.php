<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'name' => 'John',
                'email' => 'john@gmail.com',
                'password' => bcrypt('123456'),
                'document' => 12345678
            ],
            [
                'name' => 'Simon',
                'email' => 'simon@gmail.com',
                'password' => bcrypt('123456'),
                'document' => 678901234
            ],
        ];

        foreach ($users as $user) \Illuminate\Support\Facades\DB::table('users')->insert($user);

    }
}
