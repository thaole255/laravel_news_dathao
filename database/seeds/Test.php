<?php

use Illuminate\Database\Seeder;

class Test extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 10; $i++) { 
    		DB::table('Test')->insert([
         	'Name'=>'Users_'.$i,
         	'created_at'=> new DateTime()
         ]);
    	}
         
    }
}
