<?php

namespace App\Models;

use PDO;

/*
 * Post model
*/
class Post {
  /*
   * Get all the posts as an assoc array
   * @return array
  */
  public static function all() {
    $host = 'localhost';
    $dbname = 'mvc';
    $username = 'root';
    $password = 'admin';
    try {
      $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
      $stmt = $db->query('SELECT * FROM posts ORDER BY created_at');
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
