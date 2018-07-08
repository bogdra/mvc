<?php

/**
 * Class that checks if data has been submited and handles the data before evaluation
 * 
 * @category MVC
 * @package  MVC
 * @author   Bogdan Dragoi <bogdan.dragoi@gmail.com>
 * @license  MIT 
 * @link     ***
 */
class Input
{
    /** 
     * Checks if data exists in the super global array GET or POST
     * 
     * @param string $type The type of global array to check if it has submmited data
     * 
     * @return boolean 
     */
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false ;
                break;
            
            case 'get':
                return (!empty($_GET)) ? true : false ;
                break;

            default:
                return false;
                break;
        }
        
    }


    /**
     * Extract the variable form post or get super global , 
     * sanitizes it and returns it
     * 
     * @param string $input The input variable to extract from post or get
     * 
     * @return string The sanitized output
     */
    public static function get($input)
    {
        if (isset($_POST[$input])) {

            return self::sanitize($_POST[$input]);

        } elseif (isset($_POST[$input])) {

            return self::sanitize($_GET[$input]);

        }
    }


    /**
     * Sanitizes the data for non valid characters
     * 
     * @param string $data The data that we are going to sanitize
     * 
     * @return string sanitized data
     */
    public static function sanitize($data)
    {
        return htmlentities($data, ENT_QUOTES, "UTF-8");
    }

}