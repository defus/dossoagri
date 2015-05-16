<?php
    class CultureZones extends Eloquent
    {
      protected $table = 'culturezones';
      
      protected $primaryKey = 'id';

      public $incrementing = true;

      public $timestamps = true;
      
       // Relationships
       public function CultureZonePeriods()
      {
        return $this->hasMany('CultureZoneCulturePeriods', 'zoneid');
      }
    
    }   
