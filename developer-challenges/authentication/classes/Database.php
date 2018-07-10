<?php
/**
 * Class for handling database interaction
 */

class Database {

  /**
   * Attributes
   */
  private $connection;
  private $serverName = '';
  private $database = '';
  private $username = '';
  private $password = '';

  /**
   * Constructor
   */
  function __construct()
  {
    try {
      $this->connection = new PDO("mysql:host=$this->serverName;dbname=$this->database", $this->username, $this->password);
      // set the PDO error mode to exception
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  /**
   * Methods
   */
  function getConnection()
  {
    return $this->connection;
  }

}
