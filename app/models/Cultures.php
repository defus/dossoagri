<?php
    class Cultures extends Eloquent
    {
      protected $table = 'cultures';
      
      protected $primaryKey = 'id';

      public $incrementing = true;

      public $timestamps = true;
      
    }   