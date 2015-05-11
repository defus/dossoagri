<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'utilisateur';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $primaryKey = 'UtilisateurID';

	public $timestamps = false;

	public function getAuthIdentifier()
	{
		return $this->attributes['UtilisateurID'];
	}

	public function login($data) {
        //Unset token
        unset($data['_token']);
        $validation = Validator::make($data, array(
                    //'email' => 'required|email',
                    'email' => 'required',
                    'password' => 'required'
        ));
        $data = array('username' => $data['email'], 'password' => $data['password']);
        if ($validation->passes() ) {
        		$user = User::where('username', '=', $data['username'])->first();
        		if(isset($user)) {
						    if($user->password == md5($data['password'])) { // If their password is still MD5
						        //$user->password = Hash::make(Input::get('password')); // Convert to new format
						        //$user->save();
						        Auth::login($user);
						        return TRUE;
						    }
						}
        }
        return $validation;
    }

}
