<?php
// All internal details of recording visitor statistics are encapsulated in this class
// At the moment this includes our choice of data-storage: a MySQL database
// It is particularly important that errors from the database are NEVER passed out of this class
// These have a habit of revealing credentials
// They are useful for debugging, so we do log them
class VisitorStatistics {
  private static $dbConnection;



  // *************************************************************************
  //                             PUBLIC FUNCTIONS
  // *************************************************************************


  public static function recordVisit() {
    self::connectToDBIfNeeded();

    // We'll use SQL INSERT to record the current user-agent-string
    // Note that our table-schema automatically adds a timestamp
    try {
      $statement = self::$dbConnection->prepare('INSERT INTO pageVisits (user_agent_string) VALUES (?)');
    } catch (PDOException $e) {
      error_log($e->getMessage());
      throw new Exception('Preparing insert statement failed');
    }
    try {
      $statement->execute([$_SERVER['HTTP_USER_AGENT']]);
    } catch (PDOException $e) {
      error_log($e->getMessage());
      throw new Exception('Executing insert statement failed');
    }
  }


  public static function getVisits() {
    self::connectToDBIfNeeded();

    try {
      $statement = self::$dbConnection->prepare('SELECT user_agent_string, date_created from pageVisits');
    } catch (PDOException $e) {
      error_log($e->getMessage());
      throw new Exception('Preparing select statement failed');
    }
    try {
      $statement->execute();
    } catch (PDOException $e) {
      error_log($e->getMessage());
      throw new Exception('Executing select statement failed');
    }

    $results = $statement->fetchAll();
    if ($results) // Before PHP 8, fetchAll could return false
      return $results;
    return [];
  }




  // *************************************************************************
  //                             PRIVATE FUNCTIONS
  // *************************************************************************


  private static function connectToDBIfNeeded() {
    if (isset(self::$dbConnection))
      return;

    if(!(include 'db-credentials.php')) // Sets $dbHost, $dbName, $dbUser, $dbPassword
      throw new Exception("Couldn't load database credentials file");

    try {
      self::$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    } catch (PDOException $e) {
      error_log($e->getMessage());
      throw new Exception('Connecting to database failed');
    }
  }
}


?>
