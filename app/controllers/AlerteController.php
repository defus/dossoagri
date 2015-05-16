<?php
use Illuminate\Support\Facades\Facade;

class AlerteController extends \BaseController {
   
  
    public function index()
    {
      $baseid = Auth::user()->BaseID; 

      return  View::make('alerte.index');
    }

    public function datatable(){

      $draw = \Input::get('draw');
      $start = \Input::get('start', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('search');
      $order = \Input::get('order');
      $columns = \Input::get('columns');


      $query = DB::table('alerte')
        ->leftJoin('evenement', 'evenement.EvenementID', '=', 'alerte.EvenementID')
		 ->leftJoin('utilisateur', 'utilisateur.UtilisateurID', '=', 'alerte.initiateurID');
        

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(evenement.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(evenement.Description)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          
        });
      }

      $total_search = $query->count();

      if (!is_null($start) && !is_null($length)) {
        $query = $query->skip($start)->take($length);
      }

      if (is_array($order) && count($order) > 0) {
          for ($i = 0, $c = count($order); $i < $c; $i++) {
              $order_col = (int)$order[$i]['column'];
              if (isset($columns[$order_col])) {
                  if ($columns[$order_col]['orderable'] == "true") {
                      $query->orderBy($columns[$order_col]['name'], $order[$i]['dir']);
                  }
              }
          }
      }
      $list = $query->select('alerte.*', 'evenement.Nom as event_nom')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    public function create()
    {
      return View::make('alerte.create');
       
    }

    public function store(){
      $validation = Validator::make(\Input::all(), 
        array(
          'EvenementID' => 'required|numeric',
          'DateCreation' => 'required|date_format:"d/m/Y"',
          'Message' => 'required'
          ), 
        array(
          'EvenementID.required' => "L'evenement selectionne n'est pas valide",
          'EvenementID.numeric' => "L'evenement selectionne n'est pas valide",
          'DateCreation.date_format' => "La date de creation n'est pas une date valide au format (DD/MM/YYYY)",
          'DateCreation.required' => "Merci de remplir le champ Date de creation"        
        )
      );

      if ($validation->fails()) {
          return Redirect::to('alerte/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateCreation = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('DateCreation'));
          
          $alerte = new Alerte();
          
          $alerte->EvenementID = \Input::get('EvenementID');
          
          $alerte->DateCreation = $dateCreation->toDateString();
          $alerte->Message = \Input::get('Message');
          
          $alerte->InitiateurID = Auth::user()->UtilisateurID;
          
          $alerte->save();

          $modifierUrl = URL::to('alerte/' . $alerte->AlerteID . '/edit');
          Session::flash('success', "<p>Création de l'alerte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier l'alerte</a></p>");
          return Redirect::to('alerte');
        }
    }

    public function storeSMS(){
    	
    	/*$sender = \Input::get('sender');
    	$keyword = \Input::get('keyword');
    	$sendtime = new Datetime( \Input::get('sendtime') );
    	$param = \Input::get('param');    	
    	$paramArray = explode(' ', $param);
    	
    	$user = User::where('telephone', $sender)->firstOrFail();
    	$produit = Produit::where('Nom', $paramArray[0])->firstOrFail();
    	
    	$submissionData = array(
    		'Poids' => $paramArray[1],
    		'ProduitID' => $produit->ProduitID,
    		'AgriculteurID' => $user->UtilisateurID,
    		'DateSoumission' => $sendtime->format('d/m/Y'),
    		'StatutSoumission' => 'SOUMIS',
    		'CanalSoumission' => 'SMS'
    	);
    	
    	$validation = Validator::make($submissionData,
    			array(
    					'Poids' => 'required|numeric',
    					'ProduitID' => 'required|numeric',
    					'AgriculteurID' => 'required|numeric',
    					'DateSoumission' => 'required|date_format:"d/m/Y"',
    					'StatutSoumission' => 'required',
    					'CanalSoumission' => 'required'
    			),
    			array(
    					'Poids.required' => "Merci de renseigner le poids",
    					'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
    					'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
    					'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
    					'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
    					'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
    					'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
    					'ProduitID.required' => "Le produit sélectionné n'est pas valide"
    			)
    	);
    
    	if ($validation->fails()) {
    		return Redirect::to('recolte/create')
    		->withErrors($validation)
    		->withInput(\Input::all());
    	} else {
    		$dateSoumission = \Carbon\Carbon::createFromFormat('d/m/Y', $submissionData['DateSoumission']);
    
    		$recolte = new Recolte();
    		$recolte->Poids = $submissionData['Poids'];
    		$recolte->ProduitID = $submissionData['ProduitID'];
    		$recolte->AgriculteurID = $submissionData['AgriculteurID'];
    		$recolte->DateSoumission = $dateSoumission->toDateString();
    		$recolte->StatutSoumission = $submissionData['StatutSoumission'];
    		$recolte->CanalSoumission = $submissionData['CanalSoumission'];
    		$recolte->InitiateurID = Auth::user()->UtilisateurID;
    
    		$recolte->save();
    		
    		$ws = New SMSWebServices(Facade::getFacadeApplication());
    		$msg = "Votre recolte de " . $submissionData['Poids'] . " KG de " . $submissionData['ProduitID'] . " a bien ete enregistree. Merci."; 
    		$ws->sendmsg($sender, $msg);
    
    		$modifierUrl = URL::to('recolte/' . $recolte->RecolteID . '/edit');
    		Session::flash('success', "<p>Création de la récolte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la récolte</a></p>");
    		return Redirect::to('recolte');
    	}*/
    }
    
    public function edit($id)
    {
      $alerte = Alerte::find($id);

      return View::make('alerte.edit')
        ->with('alerte', $alerte);
      

    }

    public function update($id){

       $validation = Validator::make(\Input::all(), 
        array(
          'EvenementID' => 'required|numeric',
          'DateCreation' => 'required|date_format:"d/m/Y"',
          'Message' => 'required'
          ), 
        array(
          'EvenementID.required' => "L'evenement selectionne n'est pas valide",
          'EvenementID.numeric' => "L'evenement selectionne n'est pas valide",
          'DateCreation.date_format' => "La date de creation n'est pas une date valide au format (DD/MM/YYYY)",
          'DateCreation.required' => "Merci de remplir le champ Date de creation"        
        )
      );

      if ($validation->fails()) {
          return Redirect::to('alerte/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateCreation = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('DateCreation'));
          
          $alerte = Alerte::find($id);
          
          $alerte->EvenementID = \Input::get('EvenementID');
          
          $alerte->DateCreation = $dateCreation->toDateString();
          $alerte->Message = \Input::get('Message');
         
          
          $alerte->save();

          $modifierUrl = URL::to('alerte/' . $alerte->AlerteID . '/edit');
          Session::flash('success', "<p>Mise-à-jour l'alerte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier l'alerte</a></p>");
          return Redirect::to('recolte');
        }
    }

    public function destroy($id)
    {
      $alerte = Alerte::find($id);
      $alerte->delete();

      // redirect
      Session::flash('success', "Alerte supprimée avec succès !");
      return Redirect::to('alerte');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}