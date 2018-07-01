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
            
        /*      $db->select('users',[
                    'what' => 'username',
                    'cond' => [
                            ['first_name','=','Bogdan'],
                            ['last_name','=','Dragoi']
                            
                    ],
                    'order' => 'id',
                    'limit' => 1
             ]); */
             /*  dnd ($db->insert('users',[
                        'username'=>'dadi',
                        'password'=>'dsfdsfds',
                        'first_name'=>'Dragos',
                        'last_name'=> 'Dragoi',
                        'email'=>'dradi@yahoo.com',
                        'group_id'=>1
                        ]));
            */
            $db->update('users',['id'=>2],['first_name'=>'Bogdan Gabriel']);
            $db->select('users',[]);
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