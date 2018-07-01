<?php

class View  {

    protected   $_head ,
                $_body ,
                $_siteTitle = SITE_NAME ,
                $_outputBuffer ,
                $_layout = DEFAULT_LAYOUT.'Layout' ;

    public function __construct() 
    {

	}

    /**
     * Render action to display the content
     * 
     * @param string $viewName The name of the file in the view like "home/index"
     * 
     * @return string The content to return to the viewer
     */
    public function render($viewName) 
    {

        $viewAry = explode('/', $viewName);
        
        // the view string modified with the right DIRECTORY SEPARATOR
        $viewString         = implode(DS, $viewAry);

        $fullViewPath       = ROOT .DS. 'views' .DS. $viewString . '.php';
        $fullLayoutPath     = ROOT .DS. 'views' .DS. 'layouts' .DS. $this->_layout . '.php' ;
            
        // dnd($fullViewPath);
        if (file_exists( $fullViewPath )) 
        {

			include( $fullViewPath );
            include( $fullLayoutPath );
            

        } else 
        {
			die('The view ' .$viewName. ' does not exists ');
		}

    }
    
  

  
    /**
     * Getter function that returns the protected properties _body or _head
     * 
     * @param string $type The type can be _body or _head
     */
    public function content($type) 
    {

        if ($type == 'head') {
        
            return $this->_head;

        } elseif ($type = 'body') 
        {

			return $this->_body;

		}

    return false;

	}



    //used to output content in the layout
	public function start($type) {

		$this->_outputBuffer = $type;
		ob_start();

    }
    


	public function end() {

		if ($this->_outputBuffer == 'head') {

			$this->_head = ob_get_clean();

		} elseif ($this->_outputBuffer == 'body' ) {

			$this->_body = ob_get_clean();

		} else {

			die ('You must first run the <b>start</b> method');

		}

	}



	public function setSiteTitle($title) {

		$this->_siteTitle = $title;
	}



	public function getSiteTitle() {

		return $this->_siteTitle;
	}
//------------------------------------------------


	public function setLayout($path) {

		$this->_layout = $path;
	}


}
