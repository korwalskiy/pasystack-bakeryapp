<?php

use Illuminate\Database\Seeder;

class TransferSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transfer_settings')->truncate();

        DB::table('transfer_settings')->insert([
            'id' => 1,
            'label_name' => 'Require OTP For Transfers',
            'name' => 'require_otp',
            'value' => 'false',
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ]);
    }
}
