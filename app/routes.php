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
      
      Route::resource('negociationrecolte', 'NegociationRecolteController');
      Route::get('negociationrecolte/{recolteID}/create', 'NegociationRecolteController@negociationRecolteCreate');
      Route::post('negociationrecolte/{recolteID}/store', 'NegociationRecolteController@negociationRecolteStore');
      Route::get('negociationrecolte/{recolteID}/edit/{negociationRecoleID}', 'NegociationRecolteController@negociationRecolteEdit');
      Route::post('negociationrecolte/{recolteID}/update/{negociationRecolteID}', 'NegociationRecolteController@negociationRecolteUpdate');
      Route::get('negociationrecolte/datatable/ajax', 'NegociationRecolteController@datatable');
      
      Route::get('produit/select2/ajax', 'ProduitController@select2');
      
      Route::get('agriculteur/select2/ajax', 'AgriculteurController@select2');

      // Admin
      Route::resource('admin/user', 'UserController');

      Route::resource('admin/role', 'RoleController');
      
      // Cultures 
      Route::resource('cultures', 'CultureController@index');
      Route::resource('culture/new', 'CultureController@create');
      Route::resource('culture/save', 'CultureController@store');
      Route::get('culture/{id}', array('as'=>'culturedetail', 'uses'=> 'CultureController@show'));
      Route::get('culture/{id}/modify', array('as'=>'cultureedit', 'uses'=> 'CultureController@edit'));
      Route::resource('culture/update', 'CultureController@update');
      
       //Zone de  Cultures 
      Route::resource('culturezones', 'CultureZoneController@index');
      Route::resource('culturezone/new', 'CultureZoneController@create');
      Route::resource('culturezone/save', 'CultureZoneController@store');
      Route::get('culturezone/{id}', array('as'=>'culturezonedetail', 'uses'=> 'CultureZoneController@show'));
      Route::get('culturezone/{id}/modify', array('as'=>'culturezoneedit', 'uses'=> 'CultureZoneController@edit'));
      Route::resource('culturezone/update', 'CultureZoneController@update');

  });

});
