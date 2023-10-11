<?php

$ROOT_PATH=getenv('ROOT_PATH');
if($ROOT_PATH==""){
    echo "Path not set. System terminated";
    exit;
}

require_once $ROOT_PATH . "/assets/core/err.php";

class StaffData{
    //Common Properties associate with database table 
    // usr table's column names
    public $staff_id;
    public $staff_branch_id;
    public $staff_name;
    public $staff_password;
    public $staff_ic;
    public $staff_sex;
    public $staff_race;
    public $staff_religion;
    public $staff_birth_date;
    public $staff_designation;
    public $staff_job_division;
    public $staff_job_status;
    public $staff_system_access;
    public $staff_system_level;
}


class Staff extends StaffData {
    public $data;
    public $msg;
    public $status;
    public $status_code;
    public $total_data;
    //Standard Filter for listing by page limit. Use for paging
    public $page_start;
    public $page_limit;

    //Standard Properties
    public $user_id;//User id that access this class
    public $branch_id;//Branch id that access this class
    public $app_name; //app name
    public $system_level;
    public $system_access;
    public $DB;//Class of DB connector from sql_com
    public $inactive; // for delete request

    // Class Initialized
    public function __construct($appinfo,$db, $payload){
        $this->user_id = $appinfo['user_id'];//Get userid that access 
        $this->app_name = $appinfo['app_name'];//Get app name  that access
        $this->branch_id = $appinfo['sid'];//Get branch id that access=$appinfo['from'];//Get userid that access
        $this->system_level = $appinfo['system_level'];//Get access level that access
        $this->system_access = $appinfo['system_access'];//Get access level that access
        $this->DB=$db;//Set the Db class for db connection

        // mapping payload to properties
        $this->staff_id = $payload['staff_id'] ?? null;
        $this->staff_branch_id = $payload['staff_branch_id'] ?? null;
        $this->staff_name = $payload['staff_name'] ?? null;
        $this->staff_password = $payload['staff_password'] ?? null;
        $this->staff_ic = $payload['staff_ic'] ?? null;
        $this->staff_sex = $payload['staff_sex'] ?? null;
        $this->staff_race = $payload['staff_race'] ?? null;
        $this->staff_religion = $payload['staff_religion'] ?? null;
        $this->staff_birth_date = $payload['staff_birth_date'] ?? null;
        $this->staff_designation = $payload['staff_designation'] ?? null;
        $this->staff_job_division = $payload['staff_job_division'] ?? null;
        $this->staff_job_status = $payload['staff_job_status'] ?? null;
        $this->staff_system_access = $payload['staff_system_access'] ?? null;
        $this->staff_system_level = $payload['staff_system_level'] ?? null;
    }
    
    /**
     * API response Body builder function
     * @param integer $status_code
     * @param string $status
     * @param string $msg
     * @param array $data
     */
    function resBody($status_code, $status, $msg, $data){
            $this->status_code = $status_code;
            $this->status = $status;
            $this->msg = $msg;
            $this->data = $data;
    }

    function remove_empty_keys_from_array(array $array): array{
        $new_array = [];
        foreach ($array as $key => $value) {
            if ($value != '' || $value != null) {
                $new_array[$key] = $value;
            }
        }
        return $new_array;
    }

    function extractKeysAndValues($associativeArray) {
        $payloadArray = $this->remove_empty_keys_from_array($associativeArray);
        $keys = array_keys($payloadArray);
        $values = array_values($payloadArray);
        
        return array($keys, $values);
    }

    function array_to_string_for_update_query(array $array): string {
        $string = '';
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $value = "'$value'";
            }
            $string .= $key . ' = ' . $value . ',';
        }
        $string = rtrim($string, ','); // Remove the trailing comma
        return $string;
    }

    /**
     * method name: skeleton_method 
     * Table: <table name>
     * @return boolean
     */
    function registerStaff() {
        try {
            // logic goes here
            $staff_payload = [
                'name'=>$this->staff_name,
                'pass'=>$this->staff_password,
                'ic'=>$this->staff_ic,
                'sex'=>$this->staff_sex,
                'race'=>$this->staff_race,
                'login_ts'=> date('Y-m-d H:i:s'),
                'login_period' => date('Y-m-d H:i:s'),
            ];


            list($columns, $values) = $this->extractKeysAndValues($staff_payload);

            // sql query
            // "INSERT INTO $tableName (" . implode(', ', $columns) . ") VALUES (" . implode(',', $columns) . ")";
            $sql="INSERT INTO usr (login_sta, " . implode(', ', $columns) . ") VALUES (0, '" . implode("','", $values) . "')";

            //insert query method
            $this->DB->insert($sql);


            $this->resBody(201,'success','created', null);
            return true;
        } catch (Throwable $e) {
            //if any error occurs, it will be handled here
            ErrorHandler::handleException($e, $this->app_name, $this->user_id);
            $this->resBody(400,'error','Internal Server Error',null);
            return false;
        }  
    }

    /**
     * method name: skeleton_method 
     * Table: <table name>
     * @return boolean
     */
    function fetchStaffList() {
        try {
            $sql="SELECT id,sch_id,uid,name,ic,hp,mel,job,jobdiv,jobsta FROM usr";

            //insert query method
            $result = $this->DB->select($sql);

            // echo(print_r($result));
            // echo(print_r())
            $res=[];

            // looping through result
            foreach ($result as $row) {
                $res[] = [
                    'staff_id'=> $row['id'],
                    'sch_id'=> $row['sch_id'],
                    'uid'=> $row['uid'],
                    'ic'=> $row['ic'],
                    'hp'=> $row['hp'],
                    'mel'=> $row['mel'],
                    'job'=> $row['job'],
                    'jobdiv'=> $row['jobdiv'],
                    'jobsta'=> $row['jobsta'],
                ];
            }

            $this->data = $res;

            $this->resBody(200,'success','staff',$this->data);
            return true;
        } catch (Throwable $e) {
            //if any error occurs, it will be handled here
            ErrorHandler::handleException($e, $this->app_name, $this->user_id);
            $this->resBody(400,'error','Internal Server Error',null);
            return false;
        }  
    }

    /**
     * method name: skeleton_method 
     * Table: <table name>
     * @return boolean
     */
    function fetchStaff() {
        try {
            $sql="SELECT * FROM usr WHERE id = $this->staff_id";

            //insert query method
            $result = $this->DB->select($sql);

            // echo(print_r($result));
            // echo(print_r())
            $res=[];

            // looping through result
            foreach ($result as $row) {
                $res[] = [
                    'staff_id'=> $row['id'],
                    'sch_id'=> $row['sch_id'],
                    'uid'=> $row['uid'],
                    'ic'=> $row['ic'],
                    'hp'=> $row['hp'],
                    'mel'=> $row['mel'],
                    'job'=> $row['job'],
                    'jobdiv'=> $row['jobdiv'],
                    'jobsta'=> $row['jobsta'],
                ];
            }

            $this->data = $res;

            $this->resBody(200,'success','staff',$this->data);
            return true;
        } catch (Throwable $e) {
            //if any error occurs, it will be handled here
            ErrorHandler::handleException($e, $this->app_name, $this->user_id);
            $this->resBody(400,'error','Internal Server Error',null);
            return false;
        }  
    }

    /**
     * method name: skeleton_method 
     * Table: <table name>
     * @return boolean
     */
    function updateStaff() {
        try {
            // logic goes here
            $staff_payload = [
                'name'=>$this->staff_name,
                'pass'=>$this->staff_password,
                'ic'=>$this->staff_ic,
                'sex'=>$this->staff_sex,
                'race'=>$this->staff_race,
                'sysaccess'=> $this->staff_system_access
            ];

            $staffData = $this->remove_empty_keys_from_array($staff_payload);
            $staff = $this->array_to_string_for_update_query($staffData);

            // sql query
            $sql="UPDATE usr SET $staff WHERE id = $this->staff_id";
            //insert query method
            $this->DB->update($sql);


            $this->resBody(201,'success','updated', $sql);
            return true;
        } catch (Throwable $e) {
            //if any error occurs, it will be handled here
            ErrorHandler::handleException($e, $this->app_name, $this->user_id);
            $this->resBody(400,'error','Internal Server Error',null);
            return false;
        }  
    }

    /**
     * method name: skeleton_method 
     * Table: <table name>
     * @return boolean
     */
    function deleteStaff() {
        try {
            // logic goes here
            
            // sql query
            $sql="UPDATE usr SET isdel = 1 WHERE id = $this->staff_id";

            //insert query method
            $this->DB->delete($sql);


            $this->resBody(201,'success','created', null);
            return true;
        } catch (Throwable $e) {
            //if any error occurs, it will be handled here
            ErrorHandler::handleException($e, $this->app_name, $this->user_id);
            $this->resBody(400,'error','Internal Server Error',null);
            return false;
        }  
    }


}