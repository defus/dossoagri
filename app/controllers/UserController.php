<?php
/**
 * UserController 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */

class UserController extends \BaseController {
    
    private $_userModel;

    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
        $this->beforeFilter('csrf', array('on' => 'post'));
        
        $this->_userModel = new \User();
    }

    public function index() {
        $baseid = Auth::user()->BaseID; 
        $users = User::where('BaseId', $baseid)->get();

        return \View::make('admin.user.index', array(
                    'users' => $users
        ));
    }

    public function create() {
        $username = Auth::user()->Username;
        $baseid = Auth::user()->BaseID; 

        $roles = array('USER' => 'Utilisateur', 'BATIMENT' => 'Batiment');

        return \View::make('admin.user.create', array(
            'roles' => $roles
        ));
    }

    public function store(){
      $baseid = Auth::user()->BaseID; 

      $validation = Validator::make(\Input::all(), 
        array(
          'Username' => 'required',
          'password' => 'required|min:3|confirmed'
          ), 
        array(
          'Username.required' => "Le login est obligatoire !",
          'password.required' => "Le mot de passe est obligatoire !",
          'password.min' => "Le mot de passe doit avoir au moins 3 caractères !",
          'password.confirmed' => "Les deux mots de passe saisis ne sont pas identiques !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/user/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = new User();
          $user->Username = \Input::get('Username');
          $user->BaseID = $baseid;
          $user->isbe = (\Input::has('isbe')) ? 1 : 0;
          $user->isadmin = (\Input::has('isadmin')) ? 1 : 0;
          $user->Mail = \Input::get('Mail');
          $user->password = md5(\Input::get('password'));

          $user->save();

          Session::flash('success', "Création de l'utilisateur effectuée avec succès");
          return Redirect::to('admin/user');  
          
        }
    }


    public function edit($id) {
        $baseid = Auth::user()->BaseID; 
        
        $mos = Mos::where('BaseID', $baseid)->get();
        $mos = $this->objectsToArray($mos, 'MouvrageID', 'Societe');

        $roles = array('SUPERUTILISATEUR' => 'Super utilisateur', 
            'OPERATEUR' => 'Opérateur', 
            'BATIMENT' => 'Batiment', 
            'ARRIVEEAU' => "Arrivée d'eau",
            'ECLAIRAGE' => 'Eclairage', 
            'ESPACEVERT' => 'Esaces verts', 
            'VEHICULE' => 'Véhicule', 
            'POSTEPRODUCTION' => 'Poste de production', 
            'AUTREPOSTE' => 'Autre poste', 
            'COMPTEUR' => 'Compteur', 
            'FACTURE' => 'Facture');

        $user = User::find($id);

        $username = $user->Username; 

        $userroles = Roles::where('BaseId', $baseid)->where('Username', $username)->get();

        return \View::make('admin.user.edit', array(
                    'user' => $user,
                    'roles' => $roles,
                    'mos' => $mos,
                    'userroles' => $userroles
        ));
    }

    public function update($id){
      $baseid = Auth::user()->BaseID; 

      $validation = Validator::make(\Input::all(), 
        array(
          'Username' => 'required',
          'password' => 'confirmed'
          ), 
        array(
          'Username.required' => "Le login est obligatoire !",
          'password.confirmed' => "Les deux mots de passe saisis ne sont pas identiques !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('user/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = User::find($id);
          $user->Username = \Input::get('Username');
          $user->isbe = (\Input::has('isbe')) ? 1 : 0;
          $user->isadmin = (\Input::has('isadmin')) ? 1 : 0;
          $user->Mail = \Input::get('Mail');
          $password = \Input::get('password');
          if(!empty($password)){
            $user->password = md5(\Input::get('password'));
          }
          
          $user->save();

          Session::flash('success', "Mise-à-jour de l'utilisateur effectuée avec succès");
          return Redirect::to('admin/user');
        }
    }


    public function destroy($id) {
        $user = User::find($id);
        $user->delete();

        return \Redirect::to('admin/user')
                        ->with('message', 'Utilisateur supprimé avec succès');
    }

    public function login() {
        $input = \Input::all();
        if (!empty($input)) {
            $add = $this->_userModel->login(\Input::all());
            if (TRUE === $add) {
                return \Redirect::to('');
            } else {
                return \Redirect::to(\Request::url())
                                ->withErrors($add)
                                ->withInput();
            }
        }
        return \View::make('user.login');
    }
    
    public function logout(){
        \Auth::logout();
        return \Redirect::to( '/login' );
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}