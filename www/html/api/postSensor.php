<?php
require_once __DIR__ . '/../lib/Debug.class.php';
require_once __DIR__ . '/../lib/SensorDevice.class.php';

$macaddr="NOADDR";
$msg="error";
$retmsg=array(
		"result" => "error"
);

$retcode=false;

#ini_set('display_errors', 'on');
if (!isset($_REQUEST['mac'])) {
	$retcode=false;
	$msg = "MAC Addr not found";
} else {
	$macaddr = str_replace("\r\n", '', strtolower( htmlspecialchars( $_REQUEST['mac'] ) ) );
}

$tmpl="";
if (!isset($_REQUEST['tmpl'])) {
	$retcode=false;
}else{
	$tmpl = str_replace("\r\n", '', strtolower( htmlspecialchars($_REQUEST['tmpl'])) );
}
$rh="";
if (!isset($_REQUEST['rh'])) {
	$retcode=false;
}else{
	$rh = str_replace("\r\n", '', strtolower( htmlspecialchars($_REQUEST['rh'])) );
}
$pre="";
if (!isset($_REQUEST['pre'])) {
	$retcode=false;
}else{
	$pre = str_replace("\r\n", '', strtolower( htmlspecialchars($_REQUEST['pre'])) );
}
$co2="";
if (!isset($_REQUEST['co2'])) {
	$retcode=false;
}else{
	$co2 = str_replace("\r\n", '', strtolower( htmlspecialchars($_REQUEST['co2'])) );
}
$wbgt="";
if (!isset($_REQUEST['wbgt'])) {
	$retcode=false;
}else{
	$wbgt = str_replace("\r\n", '', strtolower( htmlspecialchars($_REQUEST['wbgt'])) );
}

$val="";

$now = date(DATE_ATOM, time());
$log = $now ." -- getconf -- macaddr=". $macaddr ." /value: ". $val;
$debug = new Debug();
$debug->writeLog( $log );

$sd = new SensorDevice();
$sd->init();

$nid = (int)$sd->getNodeId($macaddr);
if( $nid != 0 ){
	$result = $sd->saveNodeData( $nid, $tmpl, $rh, $pre, $co2, $wbgt );
	
	if( $result ){
		$retmsg = array(
				"result" => "ok",
				"message" => "success",
				"data" => ""
		);
		$retcode=true;
	}else{
		$retcode=false;
		$msg = "Save error";
	}
}else{
	$retcode = false;
	$msg = "Node not found";
}

if( ! $retcode ){
	$retmsg = array(
			"result" => "error",
			"message" => $msg
	);
}

header("Content-Type: application/json; charset=UTF-8");
header("X-Content-Type-Options: nosniff");
echo json_encode($retmsg, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
