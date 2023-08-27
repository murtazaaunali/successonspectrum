<?php
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('state')->truncate();
        State::create(['state_name' => 'Alaska', 'code' => 'AK']);
        State::create(['state_name' => 'Alabama', 'code' => 'AL']);
        State::create(['state_name' => 'American Samoa', 'code' => 'AS']);
        State::create(['state_name' => 'Arizona', 'code' => 'AZ']);
        State::create(['state_name' => 'Arkansas', 'code' => 'AR']);
        State::create(['state_name' => 'California', 'code' => 'CA']);
        State::create(['state_name' => 'Colorado', 'code' => 'CO']);
        State::create(['state_name' => 'Connecticut', 'code' => 'CT']);
        State::create(['state_name' => 'Delaware', 'code' => 'DE']);
        State::create(['state_name' => 'District of Columbia', 'code' => 'DC']);
        State::create(['state_name' => 'Federated States of Micronesia', 'code' => 'FM']);
        State::create(['state_name' => 'Florida', 'code' => 'FL']);
        State::create(['state_name' => 'Georgia', 'code' => 'GA']);
        State::create(['state_name' => 'Guam', 'code' => 'GU']);
        State::create(['state_name' => 'Hawaii', 'code' => 'HI']);
        State::create(['state_name' => 'Idaho', 'code' => 'ID']);
        State::create(['state_name' => 'Illinois', 'code' => 'IL']);
        State::create(['state_name' => 'Indiana', 'code' => 'IN']);
        State::create(['state_name' => 'Iowa', 'code' => 'IA']);
        State::create(['state_name' => 'Kansas', 'code' => 'KS']);
        State::create(['state_name' => 'Kentucky', 'code' => 'KY']);
        State::create(['state_name' => 'Louisiana', 'code' => 'LA']);
        State::create(['state_name' => 'Maine', 'code' => 'ME']);
        State::create(['state_name' => 'Marshall Islands', 'code' => 'MH']);
        State::create(['state_name' => 'Maryland', 'code' => 'MD']);
        State::create(['state_name' => 'Massachusetts', 'code' => 'MA']);
        State::create(['state_name' => 'Michigan', 'code' => 'MI']);
        State::create(['state_name' => 'Minnesota', 'code' => 'MN']);
        State::create(['state_name' => 'Mississippi', 'code' => 'MS']);
        State::create(['state_name' => 'Missouri', 'code' => 'MO']);
        State::create(['state_name' => 'Montana', 'code' => 'MT']);
        State::create(['state_name' => 'Nebraska', 'code' => 'NE']);
        State::create(['state_name' => 'Nevada', 'code' => 'NV']);
        State::create(['state_name' => 'New Hampshire', 'code' => 'NH']);
        State::create(['state_name' => 'New Jersey', 'code' => 'NJ']);
        State::create(['state_name' => 'New Mexico', 'code' => 'NM']);
        State::create(['state_name' => 'New York', 'code' => 'NY']);
        State::create(['state_name' => 'North Carolina', 'code' => 'NC']);
        State::create(['state_name' => 'North Dakota', 'code' => 'ND']);
        State::create(['state_name' => 'Northern Mariana Islands', 'code' => 'MP']);
        State::create(['state_name' => 'Ohio', 'code' => 'OH']);
        State::create(['state_name' => 'Oklahoma', 'code' => 'OK']);
        State::create(['state_name' => 'Oregon', 'code' => 'OR']);
        State::create(['state_name' => 'Palau', 'code' => 'PW']);
        State::create(['state_name' => 'Pennsylvania', 'code' => 'PA']);
        State::create(['state_name' => 'Puerto Rico', 'code' => 'PR']);
        State::create(['state_name' => 'Rhode Island', 'code' => 'RI']);
        State::create(['state_name' => 'South Carolina', 'code' => 'SC']);
        State::create(['state_name' => 'South Dakota', 'code' => 'SD']);
        State::create(['state_name' => 'Tennessee', 'code' => 'TN']);
        State::create(['state_name' => 'Texas', 'code' => 'TX']);
        State::create(['state_name' => 'Utah', 'code' => 'UT']);
        State::create(['state_name' => 'Vermont', 'code' => 'VT']);
        State::create(['state_name' => 'Virgin Islands', 'code' => 'VI']);
        State::create(['state_name' => 'Virginia', 'code' => 'VA']);
        State::create(['state_name' => 'Washington', 'code' => 'WA']);
        State::create(['state_name' => 'West Virginia', 'code' => 'WV']);
        State::create(['state_name' => 'Wisconsin', 'code' => 'WI']);
        State::create(['state_name' => 'Wyoming', 'code' => 'WY']);
        State::create(['state_name' => 'Armed Forces Africa', 'code' => 'AE']);
        State::create(['state_name' => 'Armed Forces Americas (except Canada)', 'code' => 'AA']);
        State::create(['state_name' => 'Armed Forces Canada', 'code' => 'AE']);
        State::create(['state_name' => 'Armed Forces Europe', 'code' => 'AE']);
        State::create(['state_name' => 'Armed Forces Middle East', 'code' => 'AE']);
        State::create(['state_name' => 'Armed Forces Pacific', 'code' => 'AP']);
    }
}
