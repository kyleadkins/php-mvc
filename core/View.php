<?php

namespace Core;

/*
 * View
 * PHP v7.1.8
*/
class View {
  /*
   * Render a view file
   * @param string $view -- The view file
   * @return void
  */
  public static function render_template($template, $args = []) {
    static $twig = null;
    if ($twig === null) {
      $loader = new \Twig_Loader_Filesystem('../app/views');
      $twig = new \Twig_Environment($loader);
    }
    echo $twig->render($template, $args);
  }
}
