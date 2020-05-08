<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class table_user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'username'      => 'alfaben12',
            'password'       => 12345678,
            'full_name'    => 'Thariq Alfa Benriska',
            'email'      => 'alfaben@example.com',
            'phone'      => '085606330792',
            'sex'      => 'M',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
