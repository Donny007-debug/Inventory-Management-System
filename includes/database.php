<?php
require_once("config.php");
class MySqli_DB {

    private $con;

    function __construct() {
      $this->db_connect();
    }

    function db_connect()
    {
      $this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
    
      if (!$this->con) {
        die("Database connection failed: " . mysqli_connect_error());
      } else {
        // Check if the database exists
        $db_check_query = "SHOW DATABASES LIKE '" . DB_NAME . "'";
        $result = $this->con->query($db_check_query);
    
        // Create the database if it doesn't exist
        if ($result->num_rows == 0) {
          $create_db_query = "CREATE DATABASE " . DB_NAME;
          if ($this->con->query($create_db_query) === TRUE) {
            echo "Database " . DB_NAME . " created successfully.";
          } else {
            die("Failed to create database: " . $this->con->error);
          }
        }
    
        // Select the database
        $select_db = $this->con->select_db(DB_NAME);
        if (!$select_db) {
          die("Failed to select database: " . mysqli_connect_error());
        }
      }
    }
    
function db_disconnect()
{
  if(isset($this->con))
  {
    mysqli_close($this->con);
    unset($this->con);
  }
}

function query($sql)
   {

      if (trim($sql != "")) {
          $this->query_id = $this->con->query($sql);
      }
      if (!$this->query_id)
              die("Error on this Query :<pre> " . $sql ."</pre>");

       return $this->query_id;
   }

   function fetch_array($statement){
  return mysqli_fetch_array($statement);
}

 function fetch_object($statement){
  return mysqli_fetch_object($statement);
}

function fetch_assoc($statement){
  return mysqli_fetch_assoc($statement);
}

function num_rows($statement){
  return mysqli_num_rows($statement);
}

function insert_id(){
  return mysqli_insert_id($this->con);
}

function affected_rows()
{
  return mysqli_affected_rows($this->con);
}

function escape($str){
   return $this->con->real_escape_string($str);
 }

 function while_loop($loop){
 global $db;
   $results = array();
   while ($result = $this->fetch_array($loop)) {
      $results[] = $result;
   }
 return $results;
}

}

$db = new MySqli_DB();

?>
