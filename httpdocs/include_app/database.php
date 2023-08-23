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
	private $cHostName;
	private $cUserName;
	private $cPassword;
	private $cDatabase;
	private $cSqlitePath;
	private $cSqliteName;
	private $cDbType;
	private $cCharset;
	private $cCon;
	private $cSqliteRelativePath;
	function __construct($sqliteRelativePath="", $dbType = dbType, $dbCharset = dbCharset) {
		$this->cHostName = dbServer;
		$this->cUserName = dbUser;
		$this->cPassword = dbPass;
		$this->cDatabase = dbName;
		$this->cSqlitePath = sqlitePath;
		$this->cSqliteName = dbSqlite;
		$this->cDbType = $dbType;
		$this->cCharset = $dbCharset;
		$this->cSqliteRelativePath = $sqliteRelativePath;
		//データベースへ接続
		try {
			if ($this->cDbType === "sqlite") {
				//SQLite
				$this->cCon = new PDO("sqlite:{$this->cSqliteRelativePath}{$this->cSqlitePath}{$this->cSqliteName}");
			} elseif ($this->cDbType === "MySQL") {
				//MySQL
				$dsn = "mysql:dbname={$this->cDatabase};host={$this->cHostName};charset={$this->cCharset}";
				$options = [
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					// PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$this->cCharset}"
				];
				$this->cCon = new PDO($dsn, $this->cUserName, $this->cPassword, $options);
			} else {
				throw new Exception("Unsupported database type.");
			}
		} catch(PDOException $e) { 
			throw new Exception("Database connection error: " . $e->getMessage());
		}
	}
	//---------------------------
	// 検索結果
	//---------------------------
	function getRow($query, $params = [], $bindTypes = []) {
		try {
			$stmt = $this->cCon->prepare($query);
			if (!empty($bindTypes)) {
                $this->bindParams($stmt, $params);
            } else {
                $stmt->execute($params);
            }
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// INSERT, UPDATE, DELETE
	//---------------------------
	public function queryOperation($query, $params = [], $bindTypes = []){
		try {
			$stmt = $this->cCon->prepare($query);
			if (!empty($bindTypes)) {
                $this->bindParams($stmt, $params);
            } else {
                $stmt->execute($params);
            }
			return intval($this->cCon->lastInsertId());
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	//---------------------------
	// カーソルを閉じてステートメントを再実行できるようにする
	//---------------------------
	public function closeCursor() {
		$this->cCon->closeCursor();
	}
	//---------------------------
	// データベースをクローズ
	//---------------------------
	public function disconnect() {
		$this->cCon = null;
	}
	//---------------------------
	// bindのパラメーター
	//---------------------------
	private function bindParams($stmt, $params) {
		foreach ($params as $key => $value) {
			$paramType = $this->retParamType($value['type']);
			$stmt->bindValue($key + 1, $value['value'], $paramType);
		}
    }
	//---------------------------
	// bindのデータ型
	//---------------------------
	private function retParamType($type) {
		switch ($type) {
			case "PARAM_NULL":
				return PDO::PARAM_NULL;
			case "PARAM_INT":
				return PDO::PARAM_INT;
			case "PARAM_STR":
				return PDO::PARAM_STR;
			default:
				throw new Exception("Invalid parameter type.");
		}
	}
}
