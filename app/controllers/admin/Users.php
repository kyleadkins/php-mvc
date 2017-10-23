<?php

namespace App\Controllers\Admin;

/*
 * Users controller
 * PHP v7.1.8
*/

class Users extends \Core\Controller {
  /*
   * Before filter
   * @return void
  */
  protected function before() {
    // Make sure an admin user is logged in for example
    // return false;
  }

  /*
   * Show the index page
   * @return void
  */
  protected function index() {
    echo 'Hello from the index action in the Users controller!';
  }
}
