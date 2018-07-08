<?php

/** 
 * Class Validate validates the input given
 * 
 * @category Validation
 * @package  MyMVC
 * @author   bogdra <bogdan.dragoi@gmail.com>
 * @license  MIT http://
 * @link     ***
 */

class Validate
{

    private $_errors = [],
            $_passed = false,
            $_db;
    
  
    /**
     * Initializing the database connection
     * 
     * @return void;
     */
    public function __construct()
    {
        $_db = DB::getInstance();
    }



    /**
     * Method that compares the data gived against the rules
     * 
     * Usage : $items[] example:
     *       $items =[
     *           'item1' => [
     *              'rule1' => 'Username',
     *              'rule2' => true
     *           ],
     *           'item2' => [
     *              'rule1' => 'Password',
     *              'rule2' => true
     *            ]
     *       ]
     * 
     * @param array $source The post super global array that needs validation
     * @param array $items  The set of rules 
     * 
     * @return boolean      True if the validation passes
     */
    public function check($source, $items = [])
    {  
        $this->_errors = [];
       
        foreach ($items as $item => $rules) {
  
            $item = Input::sanitize($item);
           
            if (isset($rules['display'])) {
                 $display = $rules['display'];
            } 
          
           
            foreach ($rules as $rule => $rule_value) {
               
                $value = Input::sanitize(trim($source[$item]));
                
                if ($rule === 'required' && empty($value)) {
                    
                    $this->_addError("{$display} is required", $item);
                
                } elseif (!empty($value)) {

                    switch($rule) {

                    case 'min':
                        if (strlen($value) < $rule_value) {
                                
                            $this->_addError("{$display} must be a minimum of {$rule_value} characters.", $item);
                        }
                        break;

                    case 'max':
                        if (strlen($value) > $rule_value) {
                                
                            $this->_addError("{$display} must be a maximum of {$rule_value} characters.", $item);
                        }
                        break;
                    // the rule will be 'matches' => 'verify_pass'
                    case 'matches':
                        if ($value !== $source[$rule_value]) {
                                
                            $matchDisplay = $items[$rule_value]['display'];
                            $this->_addError(["{$matchDisplay} and {$display} must match",$item]);
                        }
                        break;

                    case 'unique':
                       // dnd(["SELECT {$item} FROM {$rule_value} WHERE {$item} = ?", [$value]],'unique dnd');
                        $checkIfEntryExists = DB::getInstance()->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?", [$value]);
                        //$checkIfEntryExists = DB::getInstance()->select($rule_value, ['what' => $item,'cond' => [$item => $value]);

                        if ($checkIfEntryExists->getCount()) {

                            $this->_addError("{$display} {$value} already exists. Please choose another {$display}", $item);
                        }
                        break;

                    case 'unique_update':
                        $t = explode(',', $rule_value);
                        $table = $t[0];
                        $id = $t[1];
                        $query = $this->_db->query("SELECT * FROM {$table} WHERE `id` != ? AND {$item} = ?", [$id, $value]);
                              
                        if ($query->count()) {

                            $this->_addError("{$display} already exists. Please choose another {$display}", $item);
                        }
                        break;

                    case 'is_numeric':
                              
                        if (!is_numeric($value)) {
                            $this->_addError("{$display} must only have numbers. PLease remove extra characters", $item);
                        }
                        break;

                    case 'is_alphanumeric':
                              
                        if (!ctype_alnum($value)) {
                            $this->_addError("{$display} must only have leter and numbers. Please remove extra characters", $item);
                        }
                        break;

                    case 'is_alphabetic':
                              
                        if (!ctype_alpha($value)) {
                            $this->_addError("{$display} must only have leters. Please remove extra characters", $item);
                        }
                        break;

                    case 'contains_number':
                              
                        if (!preg_match('#[0-9]#',$value)) {
                            $this->_addError("{$display} must contain at least one number. Please update it.", $item);
                        }
                        break;

                    case 'valid_email':

                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {

                            $this->_addError("{$display} must be a valid email address.", $item);
                        }
                        break;
                    }

                }

            }

        }

        if (empty($this->getErrors())) {
           
            $this->_passed = true;
        }
        return $this;

    }



    /**
     * Adds an error message to the _errors array
     * 
     * @param string $message The message that will be displayed to the user
     * @param string $item 
     * 
     * @return void
     */
    private function _addError($message ,$item)
    {
        $this->_errors[] = [$message ,$item];
    }



    /**
     * Getter method that returns the errors array
     * 
     * @return array errors found during evaluation
     */
    public function getErrors()
    {
        return $this->_errors;
    }


    /**
     * Check is passed is true
     * 
     * @return boolean True if passed is true
     */
    public function passed()
    {
        return $this->_passed;
    }


    /**
     * Displays the erros in a HTML format
     * 
     * @return string Html formated errors found during validation
     */
    public function displayErrors() 
    {
        
        $html = '<ul class=bg-danger>';

        foreach ($this->_errors as $error) {

            if (is_array($error)) {
                  
                $html .= "<li class='text-danger'> {$error[0]} </li> ";
                $html .= '<script>';
                $html .= '  jQuery("document").ready(function(){';
                $html .= '  jQuery("$'.$error[1].'").parent().closest("div")';
                $html .= '  .addClass("has-error");});';
                $html .= '</script>';
            } else {
                $html .= "<li class='text-danger'> {$error} </li> ";
            }
        }

        $html .= "</ul>";

        return $html;
    }

}