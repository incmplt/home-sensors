<?php
require_once __DIR__ . '/../lib/Debug.class.php';
require_once __DIR__ . '/../lib/SensorDevice.class.php';

$macaddr="NOADDR";
$retmsg=array(
		"result" => "error"
);

$retcode=false;

//ini_set('display_errors', 'on');
if (!isset($_REQUEST['ma'])) {
	$retcode=false;
} else {
	$macaddr = str_replace("\r\n", '', strtolower( htmlspecialchars( $_REQUEST['ma'] ) ) );
}

$val="";
if (!isset($_REQUEST['val'])) {
	$retcode=false;
}else{
	$val = strtolower( htmlspecialchars($_REQUEST['val']));
}

$now = date(DATE_ATOM, time());
$log = $now ." -- getconf -- macaddr=". $macaddr ." /value: ". $val;
$debug = new Debug();
$debug->writeLog( $log );

$sd = new SensorDevice();
$sd->init();

$nid = (int)$sd->getNodeId($macaddr);
if( $nid != 0 ){
	$result = $sd->saveData( $nid, $val );
	
	if( $result ){
		$retmsg = array(
				"result" => "ok",
				"message" => "success",
				"data" => ""
		);
		$retcode=true;
	}else{
		$retcode=false;
	}
}

if( ! $retcode ){
	$retmsg = array(
			"result" => "error"
	);
}

header("Content-Type: application/json; charset=UTF-8");
header("X-Content-Type-Options: nosniff");
echo json_encode($retmsg, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
