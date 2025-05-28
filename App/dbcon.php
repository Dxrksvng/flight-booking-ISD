<?php
	// 1. Connect to Database
	class MyDB extends SQLite3 {
		function __construct() {
		$this->open('database/airline_db.db');
		}
	}

	$db = new MyDB();

?>
