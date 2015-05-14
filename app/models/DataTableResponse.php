
<?php
    class DataTableResponse extends Eloquent
    {
      function __construct($draw,  $recordsTotal, $recordsFiltered, $data, $error) {
          $this->setAttribute('draw', $draw);
          $this->setAttribute('recordsTotal', $recordsTotal);
          $this->setAttribute('recordsFiltered', $recordsFiltered);
          $this->setAttribute('data', $data);
          $this->setAttribute('error', $error);
      } 
    }