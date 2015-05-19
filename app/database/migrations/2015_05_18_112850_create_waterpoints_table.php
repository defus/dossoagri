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
                array('name' => 'Maradi', 'description'=> 'La zone de Maradi', 'longitude'=> '7.103409', 'latitude' =>'13.482263','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Le Centre', 'description'=> 'La zone de Maradi','longitude'=>'5.2679443359375','latitude' =>'15.53837592629206','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Le Centre', 'description'=> 'La zone de Maradi','longitude'=>'5.2679443359375','latitude' =>'15.53837592629206','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Abzou', 'description'=> 'La zone de Maradi', 'longitude'=>'0.9043121337890625','latitude' =>'14.709806482462534','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Gotheye', 'description'=> 'La zone de Maradi', 'longitude'=>'1.602630615234375','latitude' =>'13.85141387383285' ,'created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Nomara', 'description'=> 'La zone de Maradi', 'longitude'=>'1.767425537109375','latitude' =>'13.696693336737654','created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Point', 'description'=> 'La zone de Maradi','longitude'=>'1.522979736328125','latitude' =>'14.053995128467742' ,'created_at'=>date('Y-m-d H:m:s')),
				array('name' => 'Say', 'description'=> 'La zone de Maradi','longitude'=>'2.366180419921875','latitude' =>'13.119604924382593','created_at'=>date('Y-m-d H:m:s'))
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
	
	
	
		 DB::table('waterpointperiods')
        ->insert(
            array(
                array('waterpointid' => 5, 'from'=> '2015-05-12', 'to'=> '2015-05-28','created_at'=>date('Y-m-d H:m:s')),
				array('waterpointid' => 6, 'from'=> '2015-05-12', 'to'=> '2015-05-28','created_at'=>date('Y-m-d H:m:s')),
				array('waterpointid' => 7, 'from'=> '2015-05-12', 'to'=> '2015-05-28','created_at'=>date('Y-m-d H:m:s')),
				array('waterpointid' => 8, 'from'=> '2015-05-12', 'to'=> '2015-05-28','created_at'=>date('Y-m-d H:m:s')),
				array('waterpointid' => 9, 'from'=> '2015-05-12', 'to'=> '2015-05-28','created_at'=>date('Y-m-d H:m:s')),
				array('waterpointid' => 10, 'from'=> '2015-05-12', 'to'=> '2015-05-28','created_at'=>date('Y-m-d H:m:s'))		
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
		Schema::drop('waterpoints');
		Schema::drop('waterpointperiods');
	}

}
