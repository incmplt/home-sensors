<?php
require_once ('config.php');

class Database {

	function getConnection() {
		$cfg = new Config();
		$pdo = NULL;

		try {
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8' "
				// PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8' ",
				// PDO::MYSQL_ATTR_READ_DEFAULT_FILE => '/etc/my.cnf',
			);
			$pdo = new PDO('mysql:dbname=' . $cfg -> dbname . ';host=' . $cfg -> dbhost, $cfg -> dbuser, $cfg -> dbpass, $options);
		} catch(PDOException $e) {
			var_dump($e);
		}
		return $pdo;

	}

	function closeConnection($pdo) {
		if (!is_null($pdo)) {
			$pdo = NULL;
		}
	}

}
?>
