<?php


class Application
{
    public function __construct()
    {
        $this->_setReporting();
        $this->_unregisterGlobals();
    

      
    }


    // function to set the error reporting on and off

    private function _setReporting()
        {
            echo DEBUG;
            try 
            {
                if ( !defined('DEBUG') )
                {  
                    throw new Exception ("The DEBUG constant is not defined. Go into config and set it up.");
                } 
            } 
            catch (Exception $e)
            {
                echo ( $e->getMessage() );
                logError( $e->getMessage() );
                die();
            }

            if (DEBUG)
            {
                error_reporting(E_ALL);
                ini_set('display_errors','On');

            } else
            {
                ini_set('display_errors','Off');
                ini_set('log_errors', 'On');
                ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
            
            }
        
        }


        // Unregister Global variables
        private function _unregisterGlobals() 
        {
	 
            if( ini_get('register_globals') ) 
            {
                
                $globalArr = ['_SESSION' ,'_COOKIE' ,'_POST' ,'_GET' ,'_REQUEST' ,'_SERVER' ,'_ENV' ,'_FILES'];
                
                foreach($globalArr as $g) 
                {
                
                    foreach( $GLOBALS[$g] as $k => $v ) 
                    {
                    
                        if  ( $GLOBALS[$g] === $v ) { unset($GLOBALS[$k]); }
                        
                    
                    }
            
                }
            }
	    }

}