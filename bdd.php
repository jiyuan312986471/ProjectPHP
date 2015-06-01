<?php

class bdd {

	private $hostname;
	private $userdb;
	private $passdb;
	private $database;
	private $connect;
	private $seldata;
	private $closedb;
	
	public function __construct($host,$user,$pass,$data) {
		$this->hostname = $host;
		$this->userdb   = $user;
		$this->passdb   = $pass;
		$this->database = $data;
	}
		
	public function Condb() {
		$connectionInfo = array("UID"=>$this->userdb, "PWD"=>$this->passdb, "Database" =>$this->database);
		$this->connect = sqlsrv_connect( $this->hostname, $connectionInfo);
		if(!$this->connect) {
			echo "Errrrooor";	
		}
		else {
			return $this->connect;
		}
	}

	public function __destruct() {
		$this->closedb = sqlsrv_close($this->connect);	
	}
	
}

?>