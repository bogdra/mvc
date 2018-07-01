<?php

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
       // echo 'home controller activated';

    }
    
    public function index()
    {
             $model = parent::_model('home');
             //dnd($model);
            // dnd($model,'dnd din controller');
            // View::render('home/index');
   
             $test = $this->twig->render('home/index.html.twig',
             [
                'menu' => [
                            ['name' => 'Home',    'link' => URL_ROOT.'/', 'last'=>'false'],
                            ['name' => 'Feachers','link' => URL_ROOT.'/feachers', 'last'=>'false'],
                            ['name' => 'About',   'link' => URL_ROOT.'/about', 'last'=>'false'],
                            ['name' => 'Contact', 'link' => URL_ROOT.'/contact', 'last'=>'true']
                ],
                'breadcrumbs' => [
                    ['name'=> 'Home', 'link' => URL_ROOT.'#'],
                    ['name'=> 'Send', 'link' => URL_ROOT.'Send', 'state' => 'active']
                ],
                'siteTitle' => SITE_NAME
             ]);
                        
            echo $test; 
    
    }

    public function test()
    {
        echo '3232323';
    }
}