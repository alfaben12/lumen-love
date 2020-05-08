<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class table_utterance_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('utterance')->insert([
            'userid' => 1,
            'qrcode' => 'qrcode12',
            'receiver' => 'Ratu Salwa',
            'message' => 'I Love U',
            'public' => true,
            'active_at' => '2020-05-28',
            'expired_at' => '2020-05-29',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
