<?php


namespace REST_API {

    function set_rest_code($code) {
        http_response_code($code);
    }

    interface Rest {

        public function onGET();
        public function onPOST();
        public function onDELETE();
        public function onPUT();

    }


    function execute_rest_api($RestClass) {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case 'GET':
                $data = $RestClass->onGET();
                break;
            
            case 'POST':
                $data = $RestClass->onPOST();
                break;
            
            case 'DELETE':
                $data = $RestClass->onDELETE();
                break;
            
            case 'PUT':
                $data = $RestClass->onPUT();
            
            default:
                $data = array();
                break;
        }

        echo json_encode($data);
    }

}