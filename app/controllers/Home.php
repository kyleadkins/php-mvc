<?php

namespace App\Controllers;

use \Core\View;

/*
 * Home controller
 * PHP v7.1.8
*/

class Home extends \Core\Controller {
  /*
   * Before filter
   * @return void
  */
  protected function before() {
    echo '(before)';
    // return false;
  }

  /*
   * After filter
   * @return void
  */
  protected function after() {
    echo '(after)';
  }

  /*
   * Show the index page
   * @return void
  */
  protected function index() {
    View::render_template('home.html', [
      'name' => 'Kyle',
      'langs' => ['Python', 'PHP', 'Ruby', 'JavaScript']
    ]);
  }
}
