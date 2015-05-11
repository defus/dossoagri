<?php 

use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Exception\InvalidArgumentException;

trait HasRole
{
    public function roles()
    {
        return $this->hasMany('Roles', 'Username', 'Username');
    }

    public function hasRole($name)
    {
        if($this->isadmin){
            return true;
        }

        foreach ($this->roles as $role) {
            //Vériier par rapport aux roles dun super utilisayeur dans un mo
            if(in_array($name, array('CONTACT', 'FACTURE', 'COMPTEUR', 'BATIMENT', 'ARRIVEEAU', 'ESPACEVERT', 'ECLAIRAGE', 'VEHICULE', 'POSTEPRODUCTION', 'AUTREPOSTE'))){
                if ($role->Role == 'SUPERUTILISATEUR') {
                    return true;
                }
            }

            //Vérifier ra rapport à un opérateur dans un mo
            if(in_array($name, array('FACTURE', 'COMPTEUR', 'BATIMENT', 'ARRIVEEAU', 'ESPACEVERT', 'ECLAIRAGE', 'VEHICULE', 'POSTEPRODUCTION', 'AUTREPOSTE'))){
                if ($role->Role == 'OPERATEUR') {
                    return true;
                }
            }

            //rechercher le role spécifique
            if ($role->Role == $name && $role->BaseID == $this->BaseID) {
                return true;
            }
        }

        return false;
    }

}
