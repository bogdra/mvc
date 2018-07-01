<?php

/**
 * Logger
 * 
 * Class log that helps looging errors
 *
 * @category MVC
 * @package  MyMVC
 * @author   Bogdan Dragoi <bogdan.dragoi@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @release  1.0.0
 * @link     *****
 */

class Logger
{
   
    protected static $pathOfGeneralErrorLogFile = LOG_ERROR_GENERAL_FILE;

    /** 
     * Constructor for logger class
     */
    public function __construct()
    {
     
    }

    /**
     * Returns a string from the current date and error msg
     * 
     * @param string $msg The error message to log
     * 
     * @return string The formated $msg - $currentTime
     */
    private static function _formatedMessage($msg)
    {
         $currentTime = date("Y-m-d H:i:s");
         return $msg.' - '.$currentTime."\n";
    }


    /**
     * Send th error to the log file
     * 
     * @param string $msg The message to log
     * 
     * @return null 
     */
    public static function logError($msg)
    {
        error_log(
            self::_formatedMessage($msg), 
            3, self::$pathOfGeneralErrorLogFile
                );
    }

}