<?php
/**
 * UserController 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */

use Illuminate\Support\Facades\Facade;

class RoleController extends \BaseController {
    
    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
        $this->beforeFilter('csrf', array('on' => 'post'));
        
        $this->_userModel = new \User();
    }

    public function store(){
      $baseid = Auth::user()->BaseID; 

      $validation = Validator::make(\Input::all(), 
        array(
          'MouvrageID' => 'required',
          'Role' => 'required',
          'UtilisateurID' => 'required'
          ), 
        array(
          'UtilisateurID.required' => "L'identifiant de l'utilisateur est obligatoire !",
          'MouvrageID.required' => "Le maître d'ouvrage est obligatoire",
          'Role.required' => "Le role est obligatoire"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/user/' . \Input::get('UtilisateurID') . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = User::find(\Input::get('UtilisateurID'));
          if(!isset($user)){
            Facade::getFacadeApplication()->abort(500, "Impossible d'ajouter le rôle à l'utilisateur. L'utilisateur n'existe pas");
          }

          $role = new Roles();
          $role->Username = $user->Username;
          $role->BaseID = $baseid;
          $role->record_id = \Input::get('MouvrageID');
          $role->Role = \Input::get('Role');
          
          $role->save();

          Session::flash('success', "Création du role de l'utilisateur effectuée avec succès");
          return Redirect::to('admin/user/' . \Input::get('UtilisateurID') . '/edit');  
          
        }
    }

    public function destroy($id) {
        $user = User::find($id);
        
        $roles = DB::table('roles')->where('Username', $user->Username)->where('Role', \Input::get('Role'))->where('record_id', \Input::get('MouvrageID'))->delete();
        
        return \Redirect::to('admin/user/' . $id . '/edit')
                        ->with('message', 'Role utilisateur supprimé avec succès');
    }

}