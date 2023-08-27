<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
			[
				'key'    => 'Address',
				'value'  => 'SW Houston, 9894 Bissonnet St #500'
        	],
			[
				'key'    => 'City',
				'value'  => 'Houston'
        	],
			[
				'key'    => 'State',
				'value'  => 'TX '
        	],
			[
				'key'    => 'Zip',
				'value'  => '77036'
        	],
			[
				'key'    => 'Phone',
				'value'  => '(346) 217-8328'
        	],
		]);
    }
}
