<?php

/** 
 * Session class 
 * 
 * @category MVC
 * @package  MVC
 * @author   Bogdan Dragoi <bogdan.dragoi@gmail.com>
 * @license  MIT http://
 * @link     ***
 */
class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

    }


    public static function exists($name)
    {
        return (array_key_exists($name,$_SESSION)) ? true : false ;
    }


    public static function get($name)
    {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }


    public static function set($name,$value)
    {
        $_SESSION[$name] = $value;
    }


    public static function delete($name)
    {
        if (self::exists($name)) {
            
            unset($_SESSION[$name]);
            return true;
        }
         return false;
    }


    public static function flash($name, $message = '')
    {
        if (self::exists($name))
        {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::set($name, $message);
        }
        return '';
    }

}