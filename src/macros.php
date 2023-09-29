<?php




namespace REST_API {
    function getParameter(string $key, array $parameter_list, string $type = 'string') {
        $result = null;

        if(isset($parameter_list[$key])) {
            $result = $parameter_list[$key];
            switch ($type) {
                case 'int':
                    $result = filter_var($result, FILTER_VALIDATE_INT);
            
                    if($result === false) {
                        fail(400, strtoupper($key).' must be an integer.');
                    }
                    break;

                case 'unsigned_integer':
                case 'uint':
                    $result = filter_var($result, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)));
            
                    if($result === false) {
                        fail(400, strtoupper($key).' must be an unsigned integer.');
                    }
                    break;

                case 'positive_integer':
                case 'pint':
                    $result = filter_var($result, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
            
                    if($result === false) {
                        fail(400, strtoupper($key).' must be a positive integer. (>0).');
                    }
                    break;

                case 'negative_integer':
                case 'nint':
                    $result = filter_var($result, FILTER_VALIDATE_INT, array('options' => array('max_range' => -1)));
                
                    if($result === false) {
                        fail(400, strtoupper($key).' must be a negative integer. (<0).');
                    }
                    break;
                
                case 'string':
                    if($result === '') {
                        $result = null;
                    }
                    break;
                
                case 'secure_string':
                case 'sstring':
                    if($result === '') {
                        $result = null;
                    }
                    else {
                        $result = htmlspecialchars($result);
                    }
                    break;
            }
        }

        return $parameter_list[$key];
    }


    function fail(int $code, string $error) {
        set_rest_code($code);
        header('Content-Type: application/json');
        echo json_encode(array('error' => $error));
        exit();
    }
}