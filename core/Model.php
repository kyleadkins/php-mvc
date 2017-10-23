<?php

namespace Core;

use PDO;
use App\Config;

/*
 * Base model
 * PHP v7.1.8
*/
abstract class Model {
  /*
   * Get the PDO database connection
   * @return mixed
  */
  protected static function get_db() {
    static $db = null;
    if ($db === null) {
      $host = Config::DB_HOST;
      $dbname = Config::DB_NAME;
      $username = Config::DB_USER;
      $password = Config::DB_PASSWORD;
      try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
    return $db;
  }
}
