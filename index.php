<?php
    require 'bootstrap.php';

    use core\Controller;    
    use core\Method;
    use core\Parameter;
    use app\classes\functions;

    try {

        $controller = new Controller;
        
        if (!isset($_SESSION))
            session_start();

        if (isset($_SESSION["user"]) || str_contains(functions::getUri(),"/apiV1"))
            $controller = $controller->load();
        else 
            $controller = $controller->load("login");

        $method = new Method();
        $method = $method->load($controller);

        $parameters = new Parameter();
        $parameters = $parameters->load($controller);

        $controller->$method($parameters);
        
    }
    catch (Exception $e){
        echo $e->getMessage();
    }

?>