<?php

namespace Core;

/*
 * Router
 * PHP v7.1.8
*/

class Router {
  /*
   * Assoc array of routes (routing table)
   * @var array
  */
  protected $routes = [];

  /*
   * Parameters of matched route
   * @var array
  */
  protected $params = [];

  /*
   * Add a route to the routing table
   * @param string $route -- The route URL
   * @param array $params -- Parameters (controller, action, etc)
   * @return void
  */
  public function add($route, $params = []) {
    // Convert route to a regex, escape forward slashes
    $route = preg_replace('/\//', '\\/', $route);

    // Convert variables e.g. {controller}
    $route = preg_replace('/\{([a-z]+)\}/', '(?<\1>[a-z-]+)', $route);

    // Convert variables with custom regex e.g. {id:\d+}
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

    // Add delimiters and case insensitive flag
    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;
  }

  /*
   * Get routes from the routing table
   * @return array
  */
  public function get_routes() {
    return $this->routes;
  }

  /*
   * Match current route to a route in the routing table,
   * setting the $params property if a route is found
   * @param string $url -- The route URL
   * @return boolean -- True if match, else false
  */
  public function match($url) {
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  /*
   * Get currently matched URL params
   * @return array
  */
  public function get_params() {
    return $this->params;
  }

  /*
   * Dispatch the route, creating the controller object and running
   * the appropriate action method
   * @param string $url -- The route URL
   * @return void
  */
  public function dispatch($url) {
    $url = $this->remove_query_str_vars($url);
    if ($this->match($url)) {
      $controller = $this->params['controller'];
      $controller = $this->convert_pascal_case($controller);
      $controller = $this->get_namespace() . $controller;
      if (class_exists($controller)) {
        $controller_obj = new $controller($this->params);
        $action = $this->params['action'];
        $action = $this->convert_snake_case($action);
        if (is_callable([$controller_obj, $action])) {
          $controller_obj->$action();
        } else {
          echo 'Method ' . $action . ' in controller ' . $controller . ' not found';
        }
      } else {
        echo 'Controller ' . $controller . ' not found';
      }
    } else {
      echo 'No route matched';
    }
  }

  /*
   * Convert string with hyphens to PascalCase
   * @param string $string -- The string to convert
   * @return string
  */
  protected function convert_pascal_case($string) {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /*
   * Convert string with hyphens to snake_case
   * @param string $string -- The string to convert
   * @return string
  */
  protected function convert_snake_case($string) {
    return str_replace('-', '_', $string);
  }

  /*
   * Remove the query string variable from the URL (if any). Because
   * the full query string is used for the route, any vars at the end will
   * need to be removed before the route is matched to the routing table.
   * Otherwise, the route won't match. Example:
   *
   * URL                           $_SERVER['QUERY_STRING']   Route
   * --------------------------------------------------------------------
   * localhost                     ''                         ''
   * localhost/?                   ''                         ''
   * localhost/?page=1             page=1                     ''
   * localhost/posts?page=1        posts&page=1               posts
   * localhost/posts/index         posts/index                posts/index
   * localhost/posts/index?page=1  posts/index&page=1         posts/index
   *
   * A URL of the format localhost/?page (one variable name, no value) won't
   * work, however (the .htaccess file converts the first ? to a & when it's
   * passed through to the $_SERVER variable)
   * @param string $url -- The full URL
   * @return string -- The URL with the query string
  */
  protected function remove_query_str_vars($url) {
    if ($url != '') {
      $parts = explode('&', $url, 2);
      if (strpos($parts[0], '=') === false) {
        $url = $parts[0];
      } else {
        $url = '';
      }
    }
    return $url;
  }

  /*
   * Get the namespace for the controller class. The namespace defined
   * in the route params is added if present
   * @return string -- The request URL
  */
  protected function get_namespace() {
    $namespace = 'App\Controllers\\';
    if (array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] . '\\';
    }
    return $namespace;
  }
}
