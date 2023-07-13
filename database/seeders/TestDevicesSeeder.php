<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class TestDevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('devices')->insert([
            'name' => 'testgeraet1',
            'deviceidentifier' => 'testgeraet1id',
            'organisation_id' => 1,
        ]);

        DB::table('devices')->insert([
            'name' => 'testgeraet2',
            'deviceidentifier' => 'testgeraet2id',
            'organisation_id' => 1,
        ]);

        DB::table('devices')->insert([
            'name' => 'testgeraet3',
            'deviceidentifier' => 'testgeraet3id',
            'organisation_id' => 2,
        ]);

        DB::table('devices')->insert([
            'name' => 'testgeraet4',
            'deviceidentifier' => 'testgeraet4id',
            'organisation_id' => 2,
        ]);

    }
}
