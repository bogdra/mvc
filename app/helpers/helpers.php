<?php


// helper function for debugging

function dnl($var,$title = null)
{
    //random color array 
    $colors = ['ebbab9','c9c5ba','cee5f2','accbe1','7c98b3','9fc8c2','8b8285','e3a8a4','f1d2cd','f0f2da'];

    $color = '#'.$colors[array_rand($colors)];

    echo('<pre style="background-color:'.$color.';">');
    if ($title) 
    {
        echo ('<h3 >--------'.$title.'--------</h3>');
    }
    var_dump($var);
    echo ('------------------------------------');
    echo('</pre>');

}

// helper function for debugging that kills the app

function dnd($var,$title = null)
{
     dnl($var,$title);
     die();
} 


function logError($string)
{
    $currentTime = date("Y-m-d H:i:s");
    error_log($string.' - '.$currentTime,3);
}