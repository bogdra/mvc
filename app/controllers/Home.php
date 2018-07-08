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

             $args = [
                 'menu' => [
                    ['name' => 'Home', 'link' => URL_ROOT.'/'],
                    ['name' => 'Feachers','link' => URL_ROOT.'/feachers'],
                    ['name' => 'About','link' => URL_ROOT.'/about'],
                    ['name' => 'Contact','link' => URL_ROOT.'/contact']
                 ],
                 'login'    => ['name'=>'Login', 'link' => URL_ROOT.'/login/login'],
                 'register' => ['name'=>'Register', 'link' => URL_ROOT.'/login/register'],
                 
                 'siteTitle' => SITE_NAME
               
                ];
            $view = View::renderTemplate('home/index.html.twig',$args) ;         
            
    
    }

    
}