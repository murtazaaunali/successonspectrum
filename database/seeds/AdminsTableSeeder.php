<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'fullname'    => 'Super Admin',
            'email'       => 'admin@sos.com',
            'type'        => 'Super Admin',
            'password'    => bcrypt('admin123'),
        ]);
    }
}
