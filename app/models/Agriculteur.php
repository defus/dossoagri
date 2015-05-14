<?php
    class Agriculteur extends Eloquent
    {
      protected $table = 'utilisateur';

      protected $hidden = array('password', 'remember_token');
      
      protected $primaryKey = 'UtilisateurID';
            
      public $timestamps = false;
      
    }   