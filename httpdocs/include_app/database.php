<?php
/**
 * PDO Database Access Class
 * 
 * @copyright EU-Create All Rights Reserved.
 * @auther EU-Create <eucreate@gmail.com>
 */

//========================================================================================================
// PDOデータベース接続
//========================================================================================================
class dbc {
	public $isConnected;
	public $cHostName;
	public $cUserName;
	public $cPassword;
	public $cDatabase;
	public $cSqlitePath;
	public $cSqliteName;
	public $cDbType;
	public $cCon;
	public $cSqliteRelativePath;
	function __construct($sqliteRelativePath="") {
		$this->cHostName = dbServer;
		$this->cUserName = dbUser;
		$this->cPassword = dbPass;
		$this->cDatabase = dbName;
		$this->cSqlitePath = sqlitePath;
		$this->cSqliteName = dbSqlite;
		$this->cDbType = dbType;
		$this->cSqliteRelativePath = $sqliteRelativePath;
		//データベースへ接続
		try {
			$this->isConnected = true;
			if ($this->cDbType === "sqlite") {
				//SQLite
				$this->cCon = new PDO("sqlite:{$this->cSqliteRelativePath}{$this->cSqlitePath}{$this->cSqliteName}");
			} else if ($this->cDbType === "MySQL") {
				//MySQL
				if (version_compare(PHP_VERSION. '5.3.6', '>=')) {
					$this->cCon = new PDO("mysql:dbname=$this->cDatabase;host=$this->cHostName;charset=utf8", $this->cUserName, $this->cPassword, array(PDO::ATTR_EMULATE_PREPARES=>false));
				} else {
					$this->cCon = new PDO("mysql:dbname=$this->cDatabase;host=$this->cHostName", $this->cUserName, $this->cPassword, array(PDO::ATTR_EMULATE_PREPARES=>false, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
				}
			}
		} catch(PDOException $e) { 
			$this->isConnected = false;
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 検索結果(1回のみ)
	//---------------------------
	function getRowOnce($query) {
		try {
			$stmt = $this->cCon->query($query);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 検索結果
	//---------------------------
	function getRow($query, $params=array(), $type=array()) {
		try {
			$stmt = $this->cCon->prepare($query);
			if (count($type) > 0) {
				for ($i = 0; $i < count($type); $i++) {
					$j = $i + 1;
					$paramType = $this->retParamType($type[$i]);
					$stmt->bindValue($j, $params[$i], $paramType);
				}
				$stmt->execute();
			} else {
				$stmt->execute($params);
			}
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 行数(SELECT)1回のみ
	//---------------------------
	function getRowSelectOnce($query) {
		try {
			$stmt = $this->cCon->query($query);
			return $stmt->fetchColumn();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// 行数(SELECT)
	//---------------------------
	function getRowSelect($query, $params=array()) {
		try {
			$stmt = $this->cCon->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchColumn();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// INSERT, UPDATE, DELETE
	//---------------------------
	public function insertRow($query, $params, $type=array()){
		try{
			$stmt = $this->cCon->prepare($query);
			if (count($type) > 0) {
				for ($i = 0; $i < count($type); $i++) {
					$j = $i + 1;
					$paramType = $this->retParamType($type[$i]);
					$stmt->bindValue($j, $params[$i], $paramType);
				}
				$stmt->execute();
			} else {
				$stmt->execute($params);
			}
			return intval($this->cCon->lastInsertId());
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	public function updateRow($query, $params, $type=array()){
		return $this->insertRow($query, $params, $type=array());
	}
	public function deleteRow($query, $params, $type=array()){
		return $this->insertRow($query, $params, $type=array());
	}
	//---------------------------
	// INSERT, UPDATE, DELETE(ONCE)
	//---------------------------
	public function insertRowOnce($query){
		try{
			$stmt = $this->cCon->query($query);
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	public function updateRowOnce($query){
		return $this->insertRowOnce($query);
	}
	public function deleteRowOnce($query){
		return $this->insertRowOnce($query);
	}
	//---------------------------
	// カーソルを閉じてステートメントを再実行できるようにする
	//---------------------------
	public function closeCursul() {
		$this->cCon->closeCursul();
	}
	//---------------------------
	// データベースをクローズ
	//---------------------------
	function Disconnect() {
		$this->cCon = null;
	}
	
	//---------------------------
	// bindのデータ型
	//---------------------------
	public function retParamType($type) {
		switch ($type) {
			case "PARAM_NULL":
				$paramType = PDO::PARAM_NULL;
				break;
			case "PARAM_INT":
				$paramType = PDO::PARAM_INT;
				break;
			case "PARAM_STR":
				$paramType = PDO::PARAM_STR;
				break;
		}
		return $paramType;
	}
}
