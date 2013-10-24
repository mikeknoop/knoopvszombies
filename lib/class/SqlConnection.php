<?php
/** 
 * SqlConnection Class for MySQL databases
 * 
 * Encapsulates a simple API for database related activities.
 * 
 * @example
 * 
 * Use the following definitions/setup:
 * 
 */
 
 define('SQL_NUM_SLAVES', 0);
 define('SQL_FAIL_SLAVE_TO_MASTER', true);
 define('SQL_MASTER_HOST', DATABASE_HOSTNAME);
 define('SQL_MASTER_USER', 'webengine');
 define('SQL_MASTER_PASS', DATABASE_PASS_FOR_WEB);
 define('SQL_MASTER_DB', DATABASE);
 define('SQL_MASTER_SOCKET', '');
 

 /**
 * To set up slaves, simply do:
 * 
 * define('SQL_NUM_SLAVES', 2);
 * $GLOBALS['SQL_SLAVE_HOST'] = array('slave1host','slave2host');
 * $GLOBALS['SQL_SLAVE_USER'] = array('slave1user','slave2user');
 * $GLOBALS['SQL_SLAVE_PASS'] = array('slave2pass','slave2pass');
 * $GLOBALS['SQL_SLAVE_DB'] = array('slave1db','slave2db');
 * $GLOBALS['SQL_SLAVE_SOCKET'] = array('/path/to/slave1.sock','/path/to/slave2.sock');
 * 
 * @access      public
 */
class SqlConnection {

    /**
     * @access private
     */
    var $_SlaveCnn = false;
    var $_MasterCnn = false;
    var $_Cnn = false;
    var $_Res = false;
    var $UseMaster = false;
    
    
    /**
     * Constructor. 
     * 
     * @return  void    
     */  
    function SqlConnection() {
    }
    
    /**
     * Attempt to connect the resource based on supplied parameters. 
     * 
     * @return  boolean 
     * @access  public
     *  
     * @param   string  (optional) Host name (Server name)
     * @param   string  (optional) User Name
     * @param   string  (optional) User Password
     * @param   string  (optional) Database Name
     */  
    function Connect() {
        $override = (func_num_args() == 4);
        if ($override) {
            // A different database has been requested other than the 
            // standard global config settings
            $host = func_get_arg(0);
            $user = func_get_arg(1);
            $pass = func_get_arg(2);
            $dbname = func_get_arg(3);
            if (! $this->_MasterCnn = mysql_connect($host, $user, $pass)) {
                    trigger_error(get_class($this) . 
                          "::Connect() -- Override -- Could not connect to master server: " . 
                          mysql_error(), E_USER_ERROR);
                    return false;
            }
            else {
                if (! mysql_select_db($dbname, $this->_MasterCnn)) {
                    trigger_error(get_class($this) . 
                           "::Connect() -- Override -- Could not connect to specified database on master server: " . 
                           mysql_error(), E_USER_ERROR);
                    return false;
                }
                else {
                    return true;
                }
            }            
        }
         
        /**
         * Short circuit out when already
         * connected.  To reconnect, pass
         * args again
         * 
         * Failover Master and Slave DB array handled here
        */
        if ($this->UseMaster || ! SQL_NUM_SLAVES) {
            // Try connection to master.
            if (is_resource($this->_MasterCnn)) {return true;}
            if (!defined('SQL_MASTER_HOST')) {
                    trigger_error(get_class($this) . 
                                '::Connect() No configuration information found for master server'
                                , E_USER_ERROR);
                    return false;
            }
            if (! $this->_MasterCnn = mysql_connect(SQL_MASTER_HOST, SQL_MASTER_USER, SQL_MASTER_PASS)) {
                    trigger_error(get_class($this) . 
                          "::Connect() Could not connect to master server: " . 
                          mysql_error(), E_USER_ERROR);
                    return false;
            }
            else {
                if (! mysql_select_db(SQL_MASTER_DB, $this->_MasterCnn)) {
                    trigger_error(get_class($this) . 
                           "::Connect() Could not connect to specified database on master server: " . 
                           mysql_error(), E_USER_ERROR);
                    return false;
                }
                else {
                    return true;
                }
            }            
        }
        elseif (!$this->UseMaster && SQL_NUM_SLAVES) {
            // Try connection to slave(s).
            if (is_resource($this->_SlaveCnn)) {return true;}
                if (!empty($GLOBALS['SQL_SLAVE_HOST'])) {
                    trigger_error(get_class($this) . 
                                '::Connect() No configuration information found for slave server'
                                , E_USER_ERROR);
                    return false;
                }
                for ($i=0;$i<SQL_NUM_SLAVES;++$i) {
                    if (! $this->_SlaveCnn = mysql_connect($GLOBALS['SQL_SLAVE_HOST'][$i]
                                                        , $GLOBALS['SQL_SLAVE_USER'][$i]
                                                        , $GLOBALS['SQL_MASTER_PASS'][$i])) {
                        trigger_error(get_class($this) . 
                            "::Connect() Could not connect to slave server [$i]: " . 
                            mysql_error(), E_USER_ERROR);
                        return false;
                    }
                }
                if (is_resource($this->_SlaveCnn)) {
                    if (! mysql_select_db($GLOBALS['SQL_SLAVE_DB'][$i], $this->_SlaveCnn)) {
                        trigger_error(get_class($this) . 
                                "::Connect() Could not connect to specified database on slave server [$i]: " . 
                                mysql_error(), E_USER_ERROR);
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                else {
                    // Failover to Master if no slaves are up?  If so, reconnect as master only
                    if (SQL_FAIL_SLAVE_TO_MASTER) {
                        $this->UseMaster = true;
                        return $this->Connect();
                    }
                }
            }           
        


    }
    
    /**
     * Executes the supplied SQL statement and returns
     * the result of the call.
     * 
     * @return  mixed   
     * @access  public
     *  
     * @param   string  SQL to execute
     */  
    function Execute( $Sql ) {
        
        /* Auto-connect to master or slave */
        if ($this->UseMaster || ! SQL_NUM_SLAVES) {
            $this->_Cnn =& $this->_MasterCnn;
        }
        elseif (! $this->UseMaster && SQL_NUM_SLAVES) {
            $this->_Cnn =& $this->_SlaveCnn;
        }
        else {
            $this->_Cnn =& $this->_MasterCnn;
        }
        if (! $this->_Cnn) {
            $this->Connect();
        }
        
        if (!$this->_Res = mysql_query($Sql, $this->_Cnn)) {
                trigger_error(get_class($this) . 
                                "::Execute() Could not execute: " . 
                                mysql_error() . 
                                " (SQL: " . $Sql . ")", E_USER_ERROR);
                return false;
        }
        else {
            return true;
        }
        
        mysql_close($this->_Cnn);
        
    }
    

    
    /**
     * Starts a transaction in the current session.
     * 
     * @return  void   
     * @access  public
     */  
    function StartTransaction() {

        $this->Execute("SET AUTOCOMMIT=0");
        $this->execute("START TRANSACTION");
        
    }
    
    /**
     * Rolls back currently executing transaction
     * 
     * @return  void   
     * @access  public
     */  
    function Rollback() {

        $this->Execute("ROLLBACK");
        $this->Execute("SET AUTOCOMMIT=1");
        
    }
    
    /**
     * Commits currently executing  transaction
     * 
     * @return  void   
     * @access  public
     */  
    function Commit() {

        $this->Execute("COMMIT");
        $this->Execute("SET AUTOCOMMIT=1");
        
    }
        
    /**
     * Reads into an array the current
     * record in the result.
     * 
     * @return  mixed   
     * @access  public
     */  
    function &ReadRecord() {

        if (! $this->_Res) {return false;}
        return mysql_fetch_assoc($this->_Res);
        
    }
    
    /**
     * Returns an array of records from the 
     * current result resource.
     * Returns empty array if no retrieval
     *
     * This method consumes more memory resources
     * than ReadRecord() but is useful to 
     * get quick record sets for processing
     *
     * Optionally, you can supply a SQL
     * string to short-cut a call to
     * SqlConnection::Execute
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  (optional) SQL to execute
     */  
    function &GetRecords() {

        // Look for a SQL string supplied
        if (func_num_args() == 1) {
            $this->Execute(func_get_arg(0));
        }

        $return = array();
        if (! is_resource($this->_Res)) {
            trigger_error(get_class($this) . 
                                "::GetRecords() : " . 
                                mysql_error(), E_USER_ERROR);
            return $return;
        }
        else {
            while ($row = mysql_fetch_assoc($this->_Res)) {
                $return[] = $row;
            }
            return $return;
        }
    }
    
    /**
     * Returns an single record array from the
     * current result resource.
     * Returns empty array if no retrieval
     *
     * Optionally, you can supply a SQL
     * string to short-cut a call to
     * SqlConnection::Execute
     * 
     * @return  mixed   
     * @access  public
     *  
     * @param   string  (optional) SQL to execute
    */  
    function &GetRecord() {
        
        // Look for a SQL string supplied
        if (func_num_args() == 1) {
            $this->Execute(func_get_arg(0));
        }
        
        if (! $this->_Res) {
            $return = array();
            return $return;
        }
        else {
            $return = mysql_fetch_assoc($this->_Res);
            return $return;
        }
    }
    
    /**
     * Returns first data point from 
     * current result resource
     * or null if no retrieval
     *
     * Optionally, you can supply a SQL
     * string to short-cut a call to
     * SqlConnection::Execute
     * 
     * @return  mixed   
     * @access  public
     *  
     * @param   string  (optional) SQL to execute
    */  
    function GetFirstCell() {
        
        // Look for a SQL string supplied
        if (func_num_args() == 1) {
            $this->Execute(func_get_arg(0));
        }
        
        if (! $this->_Res) {
            return null;
        }
        else {
            $row = mysql_fetch_row($this->_Res);
            return $row[0];
        }
    }
    
    /**
     * Returns last inserted auto-id
     * 
     * @return  mixed   
     * @access  public
    */  
    function GetLastSequence() {
        return mysql_insert_id($this->_Cnn);
    }
    
    /**
     * Returns number of rows in resultset
     * 
     * @return  int   
     * @access  public
    */  
    function NumRows() {
        return mysql_num_rows($this->_Res);
    }

    /**
     * Returns number of rows affected by DML statement
     * 
     * @return  int   
     * @access  public
    */  
    function AffectedRows() {
        return mysql_affected_rows($this->_Cnn);
    }

    /**
     * Adds slashes for insert into DB
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to escape
    */  
    function Escape($Value) {
        return addslashes($Value);
    }
    
    /**
     * Adds slashes for insert into DB
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to escape
    */  
    function StringEscape($Value) {
        return "'" . addslashes($Value) . "'";
    }
    
    /**
     * Returns either "NULL" or "'$string'" escaped for insert/update
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to evaluate
    */  
    function NullOrString($Value) {
        if (empty($Value)) {
            return 'NULL';
        }
        else {
            return "'" . addslashes($Value) . "'";
        }
    }

    /**
     * Returns either "NULL" or "'$date'" formatted for insert/update
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to evaluate
    */  
    function NullOrDate($Value) {
        if (empty($Value)) {
            return 'NULL';
        }
        else {
            return "'" . date('Y-m-d', strtotime($Value)) . "'";
        }
    }

    /**
     * Returns either "NULL" or int cast of value
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to evaluate
    */  
    function NullOrInt($Value) {
        if (empty($Value)) {
            return 'NULL';
        }
        else {
            return (int) $Value;
        }
    }

    /**
     * Returns either "NULL" or double cast of value
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to evaluate
    */  
    function NullOrDouble($Value) {
        if (empty($Value)) {
            return 'NULL';
        }
        else {
            return (double) $Value;
        }
    }

    /**
     * Returns either "0000-00-00" or "'$date'" formatted for insert/update
     * 
     * @return  mixed   
     * @access  public
     * 
     * @param   string  String to evaluate
    */  
    function StringOrDate($Value) {
        if (empty($Value)) {
            return '0000-00-00';
        }
        else {
            return "'" . date('Y-m-d', strtotime($Value)) . "'";
        }
    }
    
    /**
     * Sets the current database
     *
    */
    function SelectDb($db)
    {
      mysql_select_db($db, $this->_MasterCnn);
    }

}
?>
