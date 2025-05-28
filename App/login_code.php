<?php
	session_start();
	include('dbcon.php');
	if (isset($_POST['send'])) {
		// Get form data
		$email = $_POST['email'];
		$password = $_POST['password'];
		$login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
		$login_query_run = $db->query($login_query);
		$row = $login_query_run->fetchArray(SQLITE3_ASSOC);

		if($login_query_run and !empty($row)){
			if ($row['verify_status'] == 1)
				{
					$_SESSION['authenticated'] = TRUE;
					$_SESSION['role'] = $row['role'];
					$_SESSION['status'] = "เข้าสู่ระบบสำเร็จ";
					$_SESSION['user_id'] = $row['user_id'];

					if($row['role'] == 'customer' or $row['role'] == 'counter')
					{
						header("location: index.php");
						exit();
					}
					if($row['role'] == 'admin')
					{
						header("location: flight_list.php");
						exit();
					}

				}
			elseif($row['verify_status'] == 0)
				{
					$_SESSION['status'] = 'กรุณายืนยันอีเมล';
					header("location: login.php");
					exit();
				}
		}
		else
		{
			$_SESSION['status'] = "อีเมลหรือรหัสผ่านผิด";
			header("location: login.php");
			exit();
		}
	}
	else
	{
		$_SESSION['status'] = "ไม่สามารถเข้าถึงได้";
		header("location: login.php");
		exit();
	}

?>
