
<?php 

class notfindController extends controllerAbstract{

    public function index(){
        http_response_code(404);
    }

}

