<?php

class WaterPointController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
        return \View::make('waterpoints.index', array(
                    'waterpoints' => waterpoints::get()
        ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		 
		        return \View::make('waterpoints.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = Validator::make(\Input::all(), 
        array(
          'name' => 'required'
          ), 
        array(
          'name.required' => "Le nom est obligatoire !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('waterpoint/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $waterpoint = new waterpoints();
          $waterpoint->name = \Input::get('name');
          $waterpoint->description = \Input::get('description');
          $waterpoint->latitude = \Input::get('latitude');
		   $waterpoint->longitude = \Input::get('longitude');
          

          $waterpoint->save();

		// Save Culture Period Zone 
		$periods  = Input::only('datefrom','dateto');

             
            $datefrom = $periods['datefrom'];
            $dateto = $periods['dateto'];
            

            foreach( $cultureid as $key => $n ) {
				$arrayDateFrom = explode("/", $datefrom[$key]);
				$arrayDateTo = explode("/", $dateto[$key]);
                DB::table('waterpointperiods')->insert(
                    array(
                        'from' => $arrayDateFrom[2].'-'.$arrayDateFrom[1].'-'.$arrayDateFrom[0] ,
                        'to' => $arrayDateTo[2].'-'.$arrayDateTo[1].'-'.$arrayDateTo[0],
                        'waterpointid' => $waterpoint->id,
						'created_at'=>date('Y-m-d H:m:s')
                    )
                );
            }


          $modifierUrl = URL::to('waterpoint/' . $waterpoint->id . '/modify');
          Session::flash('success', "<p>Création effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('waterpoints');  
          
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return \View::make('waterpoints.detail')
                    ->with('waterpoint', waterpoints::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		 
		return \View::make('waterpoints.edit')
                    ->with('waterpoint', waterpoints::find($id));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$id= \Input::get('id');
		$validation = Validator::make(\Input::all(), 
        array(
          'name' => 'required'
          ), 
        array(
          'name.required' => "Le nom est obligatoire !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('waterpoint/'.$id.'/modify')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $waterpoint = waterpoints::find($id);
          
          $waterpoint->name = \Input::get('name');
          $waterpoint->description = \Input::get('description');
           $waterpoint->latitude = \Input::get('latitude');
		   $waterpoint->longitude = \Input::get('longitude');
          

          $waterpoint->save();
		  
		  
		  // Save Culture Period Zone 
		  // Clear Old Data
		  DB::table('waterpointperiods')->where('waterpointid', '=', $waterpoint->id)->delete();
		  
		$periods  = Input::only('datefrom','dateto');

            
            $datefrom = $periods['datefrom'];
            $dateto = $periods['dateto'];
            

            foreach( $cultureid as $key => $n ) {
				$arrayDateFrom = explode("/", $datefrom[$key]);
				$arrayDateTo = explode("/", $dateto[$key]);
                DB::table('waterpointperiods')->insert(
                    array(
                         
                        'from' => $arrayDateFrom[2].'-'.$arrayDateFrom[1].'-'.$arrayDateFrom[0] ,
                        'to' => $arrayDateTo[2].'-'.$arrayDateTo[1].'-'.$arrayDateTo[0],
                        'waterpointid' => $waterpoint->id,
						            'created_at'=>date('Y-m-d H:m:s')
                    )
                );
            }

          $modifierUrl = URL::to('waterpoint/' . $waterpoint->id . '/modify');
          Session::flash('success', "<p>Modification effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('waterpoints');  
          
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
