<?php
    class Alerte extends Eloquent
    {
      protected $table = 'alerte';
      
      protected $primaryKey = 'AlerteID';   
	  
	  public function __construct() {
			 parent::__construct();

			//Set the format used by Carbon when converting date to string
			\Carbon\Carbon::setToStringFormat('d-m-Y');
			//all dates like 2014-03-25 17:37:54 look like 25-03-2014 17:37:54 now
      }

	  
	  public function Evenement()
      {
        return $this->belongsTo('Evenement', 'EvenementID');
		
      }
	  
	  public function getDateCreationAttribute(){
        $dt = new \Carbon\Carbon($this->attributes['DateCreation']);
        return $dt->format('d/m/Y');
      }
	  
	  public function getEditUrlAttribute()
      {
        return URL::to('alerte/' .  $this->attributes['AlerteID'] . '/edit');
      }
	  
	  protected $appends = array('date_creation','edit_url');
      
    } 