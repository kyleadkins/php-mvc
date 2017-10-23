<?php

namespace App\Models;

use PDO;

/*
 * Post model
*/
class Post extends \Core\Model {
  /*
   * Get all the posts as an assoc array
   * @return array
  */
  public static function all() {
    try {
      $db = static::get_db();
      $stmt = $db->query('SELECT * FROM posts ORDER BY created_at');
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  /*
   * Get all the posts as an assoc array
   * @return array
  */
  public function save($data) {
    try {
      $title = $data['title'];
      $content = $data['content'];
      $db = static::get_db();
      $stmt = $db->prepare('INSERT INTO posts (title, content) VALUES (:title, :content)');
      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':content', $content);
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function destroy($id) {
    try {
      $db = static::get_db();
      $stmt = $db->prepare('DELETE FROM posts WHERE id=:id');
      $stmt->bindParam(':id', $id);
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
