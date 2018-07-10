<?php
/**
 * Class for handling database interaction
 */

class Authenticate {

  /**
   * Attributes
   */
  private $connection;


  /**
   * Constructor
   */
  function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }

  /**
   * Methods
   */
  public function checkUserDetails($username, $password)
  {
    $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $count = $stmt->rowCount();
    return $count === 1 ? true : false;
  }

  public function initiateTwoFactor($username, $twoFactorCode, $word)
  {
    $deleteStmt = $this->connection->prepare("DELETE FROM twoFactor WHERE username = :username");
    $deleteStmt->bindParam(':username', $username);
    $deleteStmt->execute();

    $insertStmt = $this->connection->prepare("INSERT INTO twoFactor (username, two_factor, word) VALUES (:username, :twoFactorCode, :word)");
    $insertStmt->bindParam(':username', $username);
    $insertStmt->bindParam(':twoFactorCode', $twoFactorCode);
    $insertStmt->bindParam(':word', $word);
    $insertStmt->execute();
  }

  public function checkTwoFactor($twoFactorCode)
  {
    $stmt = $this->connection->prepare("SELECT * FROM twoFactor WHERE two_factor = :twoFactorCode");
    $stmt->bindParam(':twoFactorCode', $twoFactorCode);
    $stmt->execute();
    $row = $stmt->fetch();
    if($row === false) return false;
    $verified = $row['verified'] == 0 ? false : true;
    return $verified;
  }

  public function googleAuthenticate($word)
  {
    $stmt = $this->connection->prepare("UPDATE twoFactor SET verified=1 WHERE word=:word");
    $stmt->bindParam(':word', $word);
    $stmt->execute();
  }

}


