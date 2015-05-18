<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementAlerteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('evenement')){
	      Schema::create('evenement', function($table)
	      {
	        $table->increments('EvenementID');
	        $table->string('Nom', 200);
			$table->string('Description', 2000);
			$table->timestamps();
	      });
	    }
		
		if(!Schema::hasTable('alerte')){
	      Schema::create('alerte', function($table)
	      {
	        $table->increments('AlerteID');
			$table->date('DateCreation');
			$table->string('Message', 5000);
			$table->integer('EvenementID')->unsigned();			
			$table->integer('InitiateurID')->unsigned();	
			$table->timestamps();
	      });
		  
		  Schema::table('alerte', function($table){
			$table->foreign('EvenementID')->references('EvenementID')->on('evenement');
			$table->foreign('InitiateurID')->references('UtilisateurID')->on('utilisateur');					
		  });
	    }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('alerte');
		Schema::dropIfExists('evenement');
	}

}
