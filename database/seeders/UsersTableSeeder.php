<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
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
        $data = [
            [
                'name'      => 'Автор не известен',
                'email'     => 'author_unknown@g.g',
                'password'  => bcrypt( Str::random(16)),
            ],
            [
                'name'      => 'Автор',
                'email'     => 'author@g.g',
                'password'  => bcrypt('123123'),
            ],
        ];
        \DB::table('users')->insert($data);
    }
}
