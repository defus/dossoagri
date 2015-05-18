<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterpointsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::beginTransaction();
		
		Schema::create('waterpoints', function($t)
		{
			$t->increments('id');
			$t->string('name', 200);
			$t->string('longitude', 100);
			$t->string('latitude', 100);
			$t->string('description',500);
			$t->timestamps();
		
		});
		
		 DB::table('waterpoints')
        ->insert(
            array(
                array('name' => 'Zinder', 'description'=> 'La zone de Zinder', 'longitude'=> '8.988161', 'latitude' =>'13.805609','created_at'=>date('Y-m-d H:m:s')),
                array('name' => 'Niamey', 'description'=> 'La zone de Niamey', 'longitude'=> '2.107531', 'latitude' =>'13.525120','created_at'=>date('Y-m-d H:m:s')),
                array('name' => 'Maradi', 'description'=> 'La zone de Maradi', 'longitude'=> '7.103409', 'latitude' =>'13.482263','created_at'=>date('Y-m-d H:m:s'))
            )
        );
		
		Schema::create('waterpointperiods', function($t)
		{
			$t->increments('id');
			$t->integer('waterpointid');
			$t->date('from');
			$t->date('to');
			$t->timestamps();
		
		});
		
		 DB::commit();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('waterpoints');
		Schema::drop('waterpointperiods');
	}

}
