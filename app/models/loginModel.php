<?php

/**
 * Login model that handles logining action, register action
 */
class loginModel extends Model
{
    protected $db ;
    protected $validateObj;

    public function __construct()
    {
        $this->db = DB::getInstance();
        $this->validateObj = new Validate();
    }

    /**
     * Check if the post array elements are given
     */
    public function checkUserAndPassValidity()
    {
       
         
        $this->validateObj->check($_POST, [
                'username' => [
                    'display' => 'Username',
                    'required' => true
                ],
                'password' => [
                    'display' => 'Password',
                    'required' => true
                ]

        ]);

        if ($this->validateObj->passed()) {
        
            return true;
        }
        return false;

    }
    /**
     * Method where we check if the username and password are valid
     */
    public function checkCredentials($username,$password)
    {
      
        if ($this->validateObj->passed()){
        
            $this->db->select('users', [ 'cond' => ['username'=> $username ], 'limit' => 1 ]);
            $rezObj = $this->db->getResults()[0];
            Session::set('loggedin',true);
            if (password_verify($password, $rezObj->password))
            {
                // dnd([$_SESSION,$rezObj],'parola gasita. Bine ai venit '.$rezObj->first_name);
                Session::flash('welcome','Bine ai venit ,'.$rezObj->first_name.' !');
                

            }
            dnd([$_SESSION,$rezObj,$password],'no password match found');

        }
      
    }

}