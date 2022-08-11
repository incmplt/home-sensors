<?php
/*
 * Author: incmplt@gmail.com
 * $Id: $
 */
require_once __DIR__ .'/config.php';
require_once __DIR__ .'/Database.class.php';
require_once __DIR__ .'/Debug.class.php';

class SensorDevice {
	var $db;
	var $pdo;
	var $debug;
	var $utils;
	
	function __construct(){
		$cfg = new config();
		$this->debug = $cfg->debug;
		$this->db = new Database();
		$this->pdo = $this->db->getConnection();
		$this->pdo->query( "set names utf8" );
	}
	
	function __destruct(){
		
	}
	
	function init(){
		$cfg = new Config();
		$this->debug = $cfg->debug;
		$this->db = new Database();
		$this->pdo = $this->db->getConnection();
		$this->pdo->query( "set names utf8" );
	}
	
	function getNodeId( $macaddr ){
		if( $macaddr === "" ){
			return 0;
		}
		$result = 0;
		if( is_null( $this->db ) ){
			$this->db = new Database();
			$this->pdo = $this->db->getConnection();
			$this->pdo->query( "set names utf8" );
		}
		$stmt = $this->pdo->prepare( "Select nid from Node where macaddr=:macaddr and idstatus='1' limit 1 " );
		$stmt->bindValue( ':macaddr', $macaddr );
		$stmt->execute();
		if( $stmt->rowCount() > 0 ){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$result = $row['nid'];
		}
		return $result;
	}
	
	function saveData( $nid, $values ){
		$result = false;
		if( is_null( $this->db ) ){
			$this->db = new Database();
			$this->pdo = $this->db->getConnection();
			$this->pdo->query( "set names utf8" );
		}
		$stmt = $this->pdo->prepare( "Insert into ValueRaw (vid,nid,effectivedate,value) values ('0',:nid,now(),:value)" );
		$stmt->bindValue('nid', $nid);
		$stmt->bindValue('value', $values);
		$flag = $stmt->execute();
		if( $flag ){
			$result=true;
		}
		return $flag;
	}

  function saveNodeData( $nid, $tmpl, $rh, $pre, $co2, $wbgt ){
    $result = false;
		if( is_null( $this->db ) ){
			$this->db = new Database();
			$this->pdo = $this->db->getConnection();
			$this->pdo->query( "set names utf8" );
		}
		$stmt = $this->pdo->prepare( "Insert into NodeValue (nvid,nid,effectivedate,temperature,humidity,pressure,co2,wbgt) values ('0',:nid,now(),:tmpl,:rh,:pre,:co2,:wbgt)" );
		$stmt->bindValue('nid', $nid);
		$stmt->bindValue('tmpl', $tmpl);
		$stmt->bindValue('rh', $rh);
		$stmt->bindValue('pre', $pre);
		$stmt->bindValue('co2', $co2);
		$stmt->bindValue('wbgt', $wbgt);
		$flag = $stmt->execute();
		if( $flag ){
			$result=true;
		}
		return $flag;
  }
}

?>
