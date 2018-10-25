<?php
namespace App\Console;

use \Illuminate\Routing\Route;

class FakeRoute extends Route {
    public function __construct($parameters=[], $methods='GET', $uri='/', $action=null)
    {
        if (is_null($action)) {
            $action = function() {

            };
        }
        parent::__construct($methods, $uri, $action);

        $this->parameters = $parameters;
    }
}