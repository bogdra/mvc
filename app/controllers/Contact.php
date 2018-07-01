<?php

class Contact extends Controller
{
    public function __construct()
    {
        parent::__construct();
       
    }


    public function index($param = '')
    {
        $model = parent::_model('contact');
        $args = [
                 'menu' => [
                    ['name' => 'Home', 'link' => URL_ROOT.'/'],
                    ['name' => 'Feachers','link' => URL_ROOT.'/feachers'],
                    ['name' => 'About','link' => URL_ROOT.'/about'],
                    ['name' => 'Contact','link' => URL_ROOT.'/contact']
                 ],
                
                 'siteTitle' => SITE_NAME
               
                ];
       
        $view  = View::renderTemplate('contact\index.html.twig',$args) ;
     
       
    }

}