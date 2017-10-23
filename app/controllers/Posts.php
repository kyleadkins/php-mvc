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
    View::render_template('posts/posts.html', [
      'posts' => $posts
    ]);
  }

  /* Show the new page
   * @return void
  */
  protected function new() {
    View::render_template('posts/new.html');
  }

  /* Create a post
   * @return void
  */
  protected function create() {
    $post = new Post();
    $post->save($_POST);
    header('Location: /posts/index');
  }

  /* Show the edit page
   * @return void
  */
  protected function edit() {
    echo 'Hello from the edit action in the Posts controller';
    echo '<p>Route params: <pre>' . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
  }

  /* Delete a post
   * @return void
  */
  protected function destroy() {
    Post::destroy($this->route_params['id']);
    header('Location: /posts/index');
  }
}
