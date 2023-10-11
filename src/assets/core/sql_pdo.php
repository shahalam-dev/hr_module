<?php

require_once $ROOT_PATH  . '/assets/core/err.php';
$DB_USERNAME=getenv('DB_USERNAME_DEV');
$DB_PASSWORD=getenv('DB_PASSWORD_DEV');
// $DB_USERNAME = getenv('DB_USERNAME_PROD');
// $DB_PASSWORD = getenv('DB_PASSWORD_PROD');

if($ROOT_PATH =="" && $DB_USERNAME_DEV=="" && $DB_PASSWORD_DEV=="" && $DB_USERNAME_PROD=="" && $DB_PASSWORD_PROD==""){
	echo "Path not set. System terminated";
	exit;
}

class PDODB extends PDO
{
	private $app_name;
	private $user_id;
	public function __construct($appInfo) {
        try {
			global $DB_USERNAME;
			global $DB_PASSWORD;
			$this->app_name = $appInfo['app_name'];
			$this->user_id = $appInfo['user_id'];
            $db = parent::__construct('mysql:host='.$appInfo['host'].';dbname='.$appInfo['db_name'], $DB_USERNAME, $DB_PASSWORD);
			parent::beginTransaction();
			
        } catch (Throwable $e) {
            ErrorHandler::handleException($e, $this->app_name, $this->user_id);
        }
	}

	public function __destruct(){
		parent::commit();
	}

	private function handleException($e) {
			parent::rollBack();
			ErrorHandler::handleException($e, $this->app_name, $this->user_id);
	}
	
	public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC) {
        try {
            $sth = $this->prepare($sql);
            foreach ($array as $key => $value) {
                $sth->bindValue("$key", $value);
            }
            $sth->execute();
            return $sth->fetchAll($fetchMode);
        } catch (Throwable $e) {
            $this->handleException($e);
			return false;
        }
	}
	
	public function insert($sql, $array = array()) {
		try {
			
			$sth = $this->prepare($sql);
			
			foreach ($array as $key => $value) {
				$sth->bindValue("$key", $value);
			}
			
			$sth->execute();

		} catch (Throwable $e) {
			$this->handleException($e);
			return false;
		}
	}
	
	public function update($sql, $array = array()) {
		try {
			$sth = $this->prepare($sql);
			
			foreach ($array as $key => $value) {
				$sth->bindValue("$key", $value);
			}
			
			$sth->execute();
		} catch (Throwable $e) {
			$this->handleException($e);
			return false;
		}
	}
	
	public function delete($sql) {
		try {
			$sth = $this->prepare($sql);
			$sth->execute();

		} catch (Throwable $e) {
			$this->handleException($e);
			return false;
		}
		
	}
	
	public function rowsCount($table) {
		try {
			$sth = $this->prepare("SELECT * FROM ".$table);
			$sth->execute();
			return $sth -> rowCount(); 
		} catch (Throwable $e) {
			$this->handleException($e);
			return false;
		}
	}
	
	public function lastInsertedId($name = null) {
		try {
			return parent::lastInsertId($name);
		} catch (Throwable $e) {
			$this->handleException($e);
			return false;
		}
	}
	
	
}