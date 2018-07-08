<?php

class Login extends Controller
{
    
   
    public function __construct()
    {
        parent::__construct();
     
    }

    public function login()
    {   
        $model = parent::_model('login');
         
        if (Input::exists()) {
        
            $model->checkUserAndPassValidity();
            $model->checkCredentials(Input::get('username'),Input::get('password'));
        
       }

       $args = [ 
                 'menu' => [
                    ['name' => 'Home', 'link' => URL_ROOT.'/'],
                    ['name' => 'Feachers','link' => URL_ROOT.'/feachers'],
                    ['name' => 'About','link' => URL_ROOT.'/about'],
                    ['name' => 'Contact','link' => URL_ROOT.'/contact']
                 ],
                 'login'    => ['name'=>'Login', 'link' => URL_ROOT.'/login/login'],
                 'register' => ['name'=>'Register', 'link' => URL_ROOT.'/login/register'],
                 
                 'siteTitle' => SITE_NAME,
                 'ROOT' => URL_ROOT
                ];

         View::renderTemplate('login/login.html.twig',$args) ;    
    }


    
    public function register()
    {
        $model = parent::_model('login');

        $args = [ 
                
            'menu' => [
                ['name' => 'Home', 'link' => URL_ROOT.'/'],
                ['name' => 'Feachers','link' => URL_ROOT.'/feachers'],
                ['name' => 'About','link' => URL_ROOT.'/about'],
                ['name' => 'Contact','link' => URL_ROOT.'/contact']
            ],

            'login'    => ['name'=>'Login', 'link' => URL_ROOT.'/login/login'],
            'register' => ['name'=>'Register', 'link' => URL_ROOT.'/login/register'],
                 
            'siteTitle' => SITE_NAME,
            'ROOT' => URL_ROOT

               
        ];
         
        if (Input::exists()) {
        
            $validateObj = new Validate;
            
            $validateObj->check($_POST, [
                
                'username' => [
                    'display'           => 'Username',
                    'required'          => true,
                    'min'               => 2,
                    'max'               => 16,
                    'is_alphanumeric'   => true,
                    'unique'            => 'users'
                ],

                'password' => [
                    'display' => 'Password',
                    'required' => true,
                    'min'=> 8,
                    'contains_number' => true
                ],

                'password_again' => [
                    'display' => 'Password again',
                    'required' => true,
                    'matches' => 'password'
                ],

                'first_name' => [
                    'display'       => 'First Name',
                    'required'      => true,
                    'min'           => 2,
                    'is_alphabetic' => true
                ],

                'last_name' => [
                    'display'       => 'Last Name',
                    'required'      => true,
                    'min'           => 2,
                    'is_alphabetic' => true
                ],
                
                'email' => [
                    'display'     => 'Email',
                    'required'    => true,
                    'min'         => 5,
                    'max'         => 150,
                    'valid_email' => true,
                    'unique'      => 'users' 
                ]

            

            ]);
            
            foreach ($_POST as $key => $value){
                $args['fields'][$key] = $value;
            }
          
            


             //dnd($validateObj->getErrors() ,'The registering errors');

         
        
        }



        if (isset($validateObj)) {
            foreach ($validateObj->getErrors() as $errors) {
                $args['errors'][$errors[1]] =  [ 'message' => $errors[0]];
            }
          dnl($args['fields'],'errors found in form');  
        }
        
        
         View::renderTemplate('login/register.html.twig',$args) ;
    }

    
    public function forgot()
    {
         /** TODO: forgot page form */ 
    }
}