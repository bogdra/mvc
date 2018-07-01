<?php

class Model 
{
     protected $_db ;
     public function __construct()
     {
        $_db = DB::getInstance();
        echo 'model parent activated<br>';
     }
     
}