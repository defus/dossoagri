<?php
    class WaterPoints extends Eloquent
    {
      protected $table = 'waterpoints';
      
      protected $primaryKey = 'id';

      public $incrementing = true;

      public $timestamps = true;
      
       // Relationships
       public function WaterPointPeriods()
      {
        return $this->hasMany('waterpointperiods', 'waterpointid');
      }
    
    }   
