<?php

use Illuminate\Database\Seeder;

class FusersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fusers')->insert([
            'fullname'    => 'Muzamil Hussain',
            'email'       => 'muzammil@geeksroot.com',
            'franchise_id'=> 1,
            'type'        => 'Owner',
            'password'    => bcrypt('admin123'),
        ]);
    }
}
