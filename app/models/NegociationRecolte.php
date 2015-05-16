<?php
    class NegociationRecolte extends Eloquent
    {
      protected $table = 'negociationrecolte';

      protected $primaryKey = 'NegociationRecolteID';

      public function __construct() {
        parent::__construct();

        //Set the format used by Carbon when converting date to string
        \Carbon\Carbon::setToStringFormat('d-m-Y');
        //all dates like 2014-03-25 17:37:54 look like 25-03-2014 17:37:54 now
      }

      public function Acheteur()
      {
        return $this->belongsTo('User', 'AcheteurID');
      }

      public function Recolte()
      {
        return $this->belongsTo('Recolte', 'RecolteID');
      }

      public function getDatepropositionFAttribute(){
        $dt = new \Carbon\Carbon($this->attributes['DateProposition']);
        return $dt->format('d/m/Y');
      }

      public function getEditUrlAttribute()
      {
        return URL::to('negociationrecolte/' .  $this->attributes['NegociationRecolteID'] . '/edit');
      }

      public function getDeleteUrlAttribute()
      {
          return URL::to('negociationrecolte/' . $this->attributes['NegociationRecolteID'] );
      }

      protected $appends = array('dateproposition_f', 'edit_url', 'delete_url');
    }
