<?php

class Controller
{
    public $view ;
    public $twig ;


    public function __construct()
    {
        //$this->view = new View();
        $loader = new Twig_Loader_Filesystem(ROOT .DS. 'views');
        $this->twig = new Twig_Environment($loader);
    }
 

    protected function _model($modelName)
    {
        $filePath = ROOT .DS. "models" .DS. lcfirst($modelName) .'Model.php';
       // dnl($filePath,'model name');
        if ( file_exists( $filePath ) )
        {
            require_once($filePath);
            return new $modelName();
        }
        return null;
    }

    
    protected function _view($viewName)
    {
        list($viewFolder,$viewFile)  = explode('/',$viewName);

        $filePath =  ROOT .DS. "views" .DS. lcfirst($viewFolder) .DS. lcfirst($viewFile) . '.php';
        if ( file_exists($filePath) )
        {
            include_once($filePath);
        }
    }

  

}