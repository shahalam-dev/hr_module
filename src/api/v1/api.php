<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $ROOT_PATH = getenv('ROOT_PATH');

    $request_body = file_get_contents('php://input');
    $payload = json_decode($request_body,true);

    require_once $ROOT_PATH . '/assets/core/api_response.php';
    require_once $ROOT_PATH . '/assets/core/handle_token.php';
    

    function get_app_info() {
        $appInfoArr = [];
        foreach (getallheaders() as $name => $value) {
            $headerKey = strtolower(str_replace('-', '_', $name));
            if($headerKey=="x_encrypted_key") $token=$value;
            // if($headerKey=="x_user_id") $appInfoArr['userID'] = $value;
        }
        
        // JWT Token class initialization
        $jwt = new JWToken();
        // Decode the token
        $appInfo = $jwt->decodeToken($token);
        // Extract the data
        foreach ($appInfo as $key => $value) {
            $appInfoArr[$key] = $value;
        }
        return $appInfoArr;
    }

    $appInfo = get_app_info();


    $appApi = function(){
        global $appInfo;
        $response = new ApiResponse(200, "success", "app info", $appInfo);
        echo $response->toJson();
    };

    $appApi();