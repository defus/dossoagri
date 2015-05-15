<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCulturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::beginTransaction();
		
		Schema::create('cultures', function($t)
		{
			$t->increments('id');
			$t->string('name', 200);
			$t->string('description', 500);
			$t->string('image',100);
			$t->timestamps();
		
		});
		
		 DB::table('cultures')
        ->insert(
            array(
                array('name' => 'ble', 'description'=> 'La culture du ble', 'image'=> 'ble.jpg','created_at'=>date('Y-m-d H:m:s')),
                array('name' => 'mil', 'description'=> 'La culture du mil', 'image'=> 'mil.jpg','created_at'=>date('Y-m-d H:m:s')),
                array('name' => 'fonio', 'description'=> 'La culture du fonio', 'image'=> 'fonio.jpg','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'mais', 'description'=> 'La culture du mais', 'image'=> 'mais.jpg','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'riz', 'description'=> 'La culture du riz', 'image'=> 'riz.jpg','created_at'=>date('Y-m-d H:m:s'))
            )
        );
		
		 DB::commit();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cultures');
		
	}

}
