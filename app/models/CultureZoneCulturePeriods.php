<?php
class CultureZoneCulturePeriods extends Eloquent {

    protected $table = 'culturezonecultureperiods';
    public $timestamps = false;

    public function Culture()
    {
        return $this->belongsTo('Cultures','cultureid');
    }
}