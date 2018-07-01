<?php

 /**    
  * Bootstrap file that includes all the necesary classes
  */

 include_once ('config' .DS. 'config.php');
 include_once ('helpers' .DS. 'helpers.php');

require (ROOT .DS. 'libraries' .DS. 'Twig' .DS. 'vendor' .DS. 'autoload.php');

function autoload($class)
{
    $directories_to_load = ['core','controllers','models','libraries'];

    foreach ($directories_to_load as $directory)
    {
        $path_of_class = ROOT .DS. $directory .DS. $class.'.php';
        
        if ( file_exists($path_of_class) )
        {
            require_once($path_of_class);
        }
    }
  
}

spl_autoload_register('autoload');