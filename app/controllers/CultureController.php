<?php

class CultureController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
        return \View::make('cultures.index', array(
                    'cultures' => Cultures::get()
        ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		        return \View::make('cultures.create');
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
          return Redirect::to('culture/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $culture = new Cultures();
          $culture->name = \Input::get('name');
          $culture->description = \Input::get('description');
          $culture->image = \Input::get('image');
          

          $culture->save();

          $modifierUrl = URL::to('culture/' . $culture->id . '/modify');
          Session::flash('success', "<p>Création effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('cultures');  
          
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
		return \View::make('cultures.detail')
                    ->with('culture', Cultures::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return \View::make('cultures.edit')
                    ->with('culture', Cultures::find($id));
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
          return Redirect::to('culture/'.$id.'/modify')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $culture = Cultures::find($id);
          
          $culture->name = \Input::get('name');
          $culture->description = \Input::get('description');
          $culture->image = \Input::get('image');
          

          $culture->save();

          $modifierUrl = URL::to('culture/' . $culture->id . '/modify');
          Session::flash('success', "<p>Modification effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('cultures');  
          
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
