<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $ROOT_PATH = getenv('ROOT_PATH');

    $request_body = file_get_contents('php://input');
    $payload = json_decode($request_body,true);

    require_once $ROOT_PATH . '/assets/core/api_response.php';
    require_once $ROOT_PATH . '/assets/core/handle_token.php';
    require_once $ROOT_PATH . '/assets/core/sql_pdo.php';
    require_once $ROOT_PATH . '/assets/module/staff.php';
    

    function get_app_info() {
        $appInfoArr = [];
        foreach (getallheaders() as $name => $value) {
            $headerKey = strtolower(str_replace('-', '_', $name));
            if($headerKey=="x_encrypted_key") $appInfoToken=$value;
            if($headerKey=="x_encrypted_user") $userInfoToken=$value;
            // if($headerKey=="x_user_id") $appInfoArr['user_d'] = $value;
        }
        
        // JWT Token class initialization
        $jwt = new JWToken();
        // Decode the token
        $appInfo = $jwt->decodeToken($appInfoToken, 'app');
        $userInfo = $jwt->decodeToken($userInfoToken, 'user');
        // Extract the data
        foreach ($appInfo as $key => $value) {
            $appInfoArr[$key] = $value;
        }
        foreach ($userInfo as $key => $value) {
            $appInfoArr[$key] = $value;
        }


        return $appInfoArr;
    }

    $appInfo = get_app_info();
    // echo(print_r($appInfo,true));

    // $appInfo = [
    //     "app_name" => "eboss",
    //     "userID" => "shahalam",
    //     "host" => "172.22.20.21",
    //     "db_name" => "testeboss",
    //     "sid" => "0"
    // ];

    //DB connection initialization
    $DB = new PDODB($appInfo);



    //Business logic class initialization
    $Staff = new Staff($appInfo,$DB, $payload);

    // $action_execution_function = function() use ($Staff){
    //     $Staff->createStaff();

    //     $response = new ApiResponse($Staff->status_code, $Staff->status, $Staff->msg, $Staff->data);
    //     echo $response->toJson();
    // };

    $registerStaff = function() use ($Staff){
        $Staff->registerStaff();

        $response = new ApiResponse($Staff->status_code, $Staff->status, $Staff->msg, $Staff->data);
        echo $response->toJson();
    };

    $fetchStaffList = function() use ($Staff){
        $Staff->fetchStaffList();

        $response = new ApiResponse($Staff->status_code, $Staff->status, $Staff->msg, $Staff->data);
        echo $response->toJson();
    };

    $fetchStaff = function() use ($Staff){
        $Staff->fetchStaff();

        $response = new ApiResponse($Staff->status_code, $Staff->status, $Staff->msg, $Staff->data);
        echo $response->toJson();
    };
    
    $updateStaff = function() use ($Staff){
        $Staff->updateStaff();

        $response = new ApiResponse($Staff->status_code, $Staff->status, $Staff->msg, $Staff->data);
        echo $response->toJson();
    };
    $deleteStaff = function() use ($Staff){
        $Staff->deleteStaff();

        $response = new ApiResponse($Staff->status_code, $Staff->status, $Staff->msg, $Staff->data);
        echo $response->toJson();
    };

    // Action not found exception handler function
    $action_not_found = function(){
        $response = new ApiResponse(404, "error", "Action not found", null);
        echo $response->toJson();
    };


    // Function execution based action
    switch ($payload ? $payload['action'] : "") {
        case 'register_staff':
                $registerStaff();
            break;
        case 'fetch_staff_list':
                $fetchStaffList();
            break;
        case 'fetch_staff':
                $fetchStaff();
            break;
        case 'update_staff':
                $updateStaff();
            break;
        case 'delete_staff':
                $deleteStaff();
            break;
        default:
                $action_not_found();
            break;
    }