<?php

use Illuminate\Database\Seeder;

class ParentDefaultDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cargohold')->insert(array(
        
			['title' => 'PARENT HANDBOOK.docx.pdf', 'franchise_id' => 0, 'category' => 'Parent Default Forms', 'user_type' => 'Parent', 'user_id' => 0, 'shared_with_clients' => 1, 'file' => '/app/public/default_docs_parent/PARENT HANDBOOK.docx.pdf'],
        
        ));
    }
}
