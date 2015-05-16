<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::group(array('prefix','/'), function() {

  Route::match(array('GET','POST'),'/login','UserController@login');

  Route::get('logout','UserController@logout');

  // Secure-Routes
  Route::group(array('before' => array('auth')), function()
  {
      Route::get('', 'DashboardController@showDashboard');
      
      Route::resource('recolte', 'RecolteController');
	  
      Route::get('recolte/datatable/ajax', 'RecolteController@datatable');
      Route::get('recolte/addsms/ajax', 'RecolteController@storeSMS');
	   
	  Route::get('produit/select2/ajax', 'ProduitController@select2');
      
      Route::get('agriculteur/select2/ajax', 'AgriculteurController@select2');
      
	  // Alerte controller.
	  Route::resource('alerte', 'AlerteController');
	  Route::get('alerte/datatable/ajax', 'AlerteController@datatable');
      Route::get('alerte/addsms/ajax', 'AlerteController@storeSMS');
      
	  Route::get('evenement/select2/ajax', 'EvenementController@select2');


      // Admin
      Route::resource('admin/user', 'UserController');

      Route::resource('admin/role', 'RoleController');

  });

});
