<?php

/**
 * Database class
 * 
 * Class that encapsulates all the DB functionality
 * 
 * @category MVC
 * @package  MyMVC
 * @author   Bogdan Dragoi <bogdan.dragoi@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     ***
 */

class DB
{

    private static $_instance = null;
    private $_PDO,              // instance of the PDO object
            $_error = false,    // errors holder
            $_lastInsertedId,
            $_result;
    public $className;

    /**
     * Instantiating a new database connection
     */
    public function __construct()
    {

        $this->className = debug_backtrace(); 
        try
        {
            $this->_PDO = new PDO(
                'mysql:host='.DB_HOST.';dbname='.DB_NAME.';', 
                DB_USER, 
                DB_PASS
            );
            $this->_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } 
        catch(PDOException $e)
        {
            Logger::logError($e->getMessage());
            dnd($e->getMessage());
        }
        
    }
    /**
     * Checks if is there another instance and if not starts a new instance
     * 
     * @return object instance
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    /**
     * Prepares and Executes the sql statement
     * 
     * @param string $sqlStatement =>The sql statement that we are going to execute 
     * @param array  $params       =>Array params to bind to the sql 
     * 
     * @return object $this 
     */
    public function query($sqlStatement, $params) 
    {
        $this->_error = false;

        try
        {
            
            $this->_query = $this->_PDO->prepare($sqlStatement);

            // check if the sql statement has been succesfully prepared
            if ($this->_query) {

                $x = 1;
                if (count($params) > 0) {
                    
                    foreach ($params as $param) {
                        
                        $this->_query->bindValue($x, $param);
                        $x++;
                    }
                }

                if ($this->_query->execute()) {

                    $this->_result         = $this->_query->fetchALL(PDO::FETCH_OBJ);
                    $this->_count          = $this->_query->rowCount();
                    $this->_lastInsertedID = $this->_PDO->lastInsertID();

                } else {

                    $this->_error = true;

                }

            }  
        }
        catch(PDOException $e)
        {
            Logger::logError($e->getMessage());
            dnd($e->getMessage(), 'DB-106');    
        }


        return $this;
            
    }
   
    
      /**
       * Base method used to select rows from DB
       * 
       * Usage :    select($table, [
       * -------------------------------
       * |          'what' => [
       *              'username',
       *              'acl'
       *            ],
       *            OR
       * |           'what' => 'name'
       * --------------------------------
       *           'cond' => [
       *               ['name','LIKE','a%'] or 'name' => 'andrei'
       *            ],
       * ------------------------------
       * |         'order' => [
       *                'name',
       *                'desc'    
       *            ], 
       *            OR
       * |          'order' => 'name',
       * -------------------------------
       *           'limit' => 20
       *          
       *         ]);
       * 
       * @param string $table  Table name where the select statement is applied
       * @param array  $params Parameters used for compiling the select sql statement
       * 
       * @return bool  True if the $this->_result is not null
       */
    public function select($table, $params)
    {
        $bindValues       = [];
        $whatFinalString  = '';
        $conditions       = '';
        $orderBy          = '';
        $limit            = '';
        $operators        = ['=','<','>','<=','>=','LIKE'];
        
        
        /**
         *  Processing the 'what' to select from the select
         *  statement like 'username','likes' or 
         */
        if (isset($params['what'])) {

            if (is_array($params['what'])) {

                foreach ($params['what'] as $what) {
                    $whatFinalString .= '? ,';
                    array_push($bindValues, $what); 
                }  
            } else {
                $whatFinalString = '?';
                array_push($bindValues, $params['what']);
            }
          
            $whatFinalString = rtrim($whatFinalString, ',');

        } else {
            $whatFinalString  = '*';
        }



        /**
         * Prossesing the conditions for the SELECT  stmt
         */
        if (isset($params['cond'])) {

            $conditions = ' WHERE ';
            if (is_array($params['cond']) ) {
            
                if (!array_key_exists(0, $params['cond'])) {
                  
                    foreach ($params['cond'] as $key => $value) {
                        $conditions .= '? = ? AND '; 
                        array_push($bindValues, $key);
                        array_push($bindValues, $value);
                    }
                } else { 
                    foreach ($params['cond'] as $condition) {
                        $conditions .= '? '.$condition[1].' ? AND '; 
                        array_push($bindValues, $condition[0]);
                        array_push($bindValues, $condition[2]);

                    }
                }
            
            }
        
            $conditions = rtrim($conditions, ' AND');
        
        } else {
            $conditions = 'WHERE 1';
        }


        /** 
         * Prosseing the order by part of the select statement
         */
        if (isset($params['order'])) {

            if (!is_array($params['order'])) {

                $orderBy = ' ORDER BY ?';
                array_push($bindValues, $params['order']);

            } else {

                $orderBy = ' ORDER BY ? ' .strtoupper($params['order'][1]);
                array_push($bindValues, $params['order'][0]);

            }
            
        }


        if (isset($params['limit'])) {

            $limit = 'LIMIT ?';
            array_push($bindValues, $params['limit']);
        }


        
        /** 
         * Calling the query method on the prepared sql stamtent
         */
        $statement  = "SELECT {$whatFinalString} FROM {$table} ";
        $statement .= "{$conditions} {$orderBy} {$limit}";
        
        if ($this->query($statement, $bindValues) ) {

            if (!count($this->_result)) { 
                return false;
            }
            return true;
        }

    }

    /**
     * Getter method for the private property $_result
     * 
     * @return array Array of results Objects
     */    
    public function getResult()
    {
        return $this->_result;
    }


    /**
     * Getter function for the private property $_lastInsertedId
     * 
     * @return array  Array of 1 element length with the last inserted element
     */  
    public function getLastId()
    {
        return $this->_lastInsertedId;
    }
 
    
}