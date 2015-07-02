<?php

class bdd {

	private $hostname;
	private $userdb;
	private $passdb;
	private $database;
	private $charset;
	private $connect;
	
	public function __construct($host,$user,$pass,$data) {
		$this->hostname = $host;
		$this->userdb   = $user;
		$this->passdb   = $pass;
		$this->database = $data;
		$this->charset  = "UTF-8";
		$this->Condb();
	}
	
	public function getConn() {
		return $this->connect;
	}
	
	private function Condb() {
		$connectionInfo = array("UID" => $this->userdb, "PWD" => $this->passdb, "Database" => $this->database,  "CharacterSet" => $this->charset);
		
		$this->connect = sqlsrv_connect( $this->hostname, $connectionInfo);
		
		//if(!mssql_select_db($this->database, $this->connect)){
		if(!$this->connect) {
			echo "Errrrooor<br/>";	
			die( print_r( sqlsrv_errors(), true));
			echo "<br/>";
		}
		else {
			return $this->connect;
		}
	}
	
	public function __destruct() {
		sqlsrv_close($this->connect);	
	}
	
}

?>