<?php

/** 
 * The core class that handles the routing extends the 
 * lass Aplication that contains the setReporting and unregisterGlobals
 */

class Router extends Application
{
    public    $url;
    protected $_currentController    = DEFAULT_CONTROLLER;
    protected $_currentAction        = DEFAULT_ACTION;
    protected $_currentParameters    = [];
   // protected $_listOfControllers    = ['home','about','contact'];



    public function __construct()
    {
        $this->getUrl();
        $this->route();
        
    }



    // We check if the provided url array is not empty and the elements are set and not ''
    private function _isUrlNotNull($url)
    {
        if ( empty($url) )
        {
            return false;
        }

        if ( isset($url[0]) && $url[0] != '')
        {
            return true;
        }

        return false;
    }



    // get the current url and break it into an array
    protected function getUrl()
    {
         $this->url = ( isset( $_GET['url'] ) ) ? explode( '/',   filter_var (   rtrim( $_GET ['url'],'/'  ), FILTER_SANITIZE_URL  )  ) : null;
        
    }



    // routes the url array to the right controller and action
	public function route() {

		// getting the controller name from the array
        if ( $this->_isUrlNotNull($this->url) )
        {
            $this->_currentController = ucwords($this->url[0]);
            array_shift($this->url);
        } 
        else 
        {
            $this->_currentController =  DEFAULT_CONTROLLER;
        }

        //getting the action
        if ( $this->_isUrlNotNull($this->url) )
        {
            $this->_currentAction = ucwords($this->url[0]);
            array_shift($this->url);
        } 
        else 
        {
            $this->_currentAction =  DEFAULT_ACTION;
        }


        //getting the params
        if ($this->url)
        {
		    $this->_currentParameters = $this->url;
        }

		//before calling the class of the controller , we first check to see if it's exist
         try
         {
            if (!class_exists($this->_currentController) )
            {
                throw new Exception('The Controller '.$this->_currentController.' does not exists.');
            } 
            else
            {
                // instantieting the controller class to check if the Action method exists in it
                 $controllerObject = new $this->_currentController;

                 try
                 {
                        if (!method_exists($controllerObject,$this->_currentAction) )
                        {
                            throw new Exception('The action '.$this->_currentAction.' requested does not exists in the controller '.$this->_currentController) ;
                        }
                        else
                        {
                                //CALLs a USER defined FUNCtion[method] from an object with an ARRAY of params
                                call_user_func_array(
                                            [$controllerObject,$this->_currentAction], 
                                            $this->_currentParameters
                                );
                        }
                 }
                 catch(Exception $e)
                 { 
                        echo ( $e->getMessage() );
                       
                       // $this->log->generalError('The action '.$this->_currentAction.' requested by the controller '.$this->_currentController.' does not exists.');
                       
                 }
            }
         }
         catch (Exception $e)
         {
            echo ( $e->getMessage() );
           // Log::generalError('The Controller '.$this->_currentController.' does not exists.');
           
         }

    }
    


    // redirect to new location
	public static function redirect($location) {

            if( !headers_sent() ) 
            {
				header('Location: ' .URL_ROOT. $location);
				exit;
            }
             else
            {
				echo ('<script type="text/javascipt">');
				echo ('window.location.href="'.URL_ROOT.$location.'";');
				echo ('</script>');
				echo ('<noscript>');
				echo ('<meta http-equiv="refresh" content="0;url='.$location.'"');
				echo ('</noscript>');
				exit;
			}

	}




}