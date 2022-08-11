<?php
require_once ('config.php');

class Debug {
	function writeLog($str) {
		$cfg = new Config();
		if (isset($cfg -> debug)) {
			file_put_contents('/tmp/debug.txt', $str . "\n", FILE_APPEND);
		}
	}

}
?>
