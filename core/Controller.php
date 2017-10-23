<?php

namespace Core;

/*
 * Base controller
 * PHP v7.1.8
*/

abstract class Controller {
  /*
   * Params from the matched route
   * @var array
  */
  protected $route_params = [];

  /*
   * Class constructor
   * @param array $route_params -- Params from the route
   * @return void
  */
  public function __construct($route_params) {
    $this->route_params = $route_params;
  }

  /*
   * Method called when a non-existent or inaccessible method
   * is called on an object of this class. Used to execute before and
   * after filters on action methods
   * @param string $name -- Method name
   * @param array $args -- Args passed to the method
   * @return void
  */
  public function __call($name, $args) {
    $method = $name;
    if (method_exists($this, $method)) {
      if ($this->before() !== false) {
        call_user_func_array([$this, $method], $args);
        $this->after();
      }
    } else {
      throw new \Exception('Method ' . $method . ' not found in controller ' . get_class($this));
    }
  }

  /*
   * Before filter
   * @return void
  */
  private function before() {
  }

  /*
   * After filter
   * @return void
  */
  private function after() {
  }
}
