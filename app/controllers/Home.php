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
             $db = DB::getInstance();
             $db->_query('SELECT * FROM users WHERE 1',[]);
             dnd ($db,'object example home.php-16');
             $model = parent::_model('home');
             //View::render('home/index');
   
             $test = $this->twig->render('home/index.html.twig',[
                 'menu' => [
                            ['name' => 'Home', 'link' => URL_ROOT.'/'],
                            ['name' => 'Feachers','link' => URL_ROOT.'/feachers'],
                            ['name' => 'About','link' => URL_ROOT.'/about'],
                            ['name' => 'Contact','link' => URL_ROOT.'/contact']
                        ],
                 'age' => 22
             ]);
           
            echo $test; 
    
    }
}