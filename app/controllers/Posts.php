<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Post;

/*
 * Posts controller
 * PHP v7.1.8
*/

class Posts extends \Core\Controller {
  /*
   * Show the index page
   * @return void
  */
  protected function index() {
    $posts = Post::all();
    View::render_template('posts.html', [
      'posts' => $posts
    ]);
  }

  /* Show the new page
   * @return void
  */
  protected function new() {
    echo 'Hello from the new action in the Posts controller';
  }

  /* Show the edit page
   * @return void
  */
  protected function edit() {
    echo 'Hello from the edit action in the Posts controller';
    echo '<p>Route params: <pre>' . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
  }
}
