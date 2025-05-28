<?php
	session_start();
	include('dbcon.php');

	if(isset($_GET['token']))
	{
		$token = $_GET['token'];
		$verify_query =<<<EOF
						SELECT verify_token, verify_status FROM users WHERE verify_token='$token' LIMIT 1;
						EOF;
		$verify_query_run = $db->query($verify_query);

		if($verify_query_run)
		{
			$row = $verify_query_run->fetchArray(SQLITE3_ASSOC);
			if($row['verify_status'] == 0)
			{
				$clicked_token = $row['verify_token'];
				$update_query =<<<EOF
					UPDATE users
					SET verify_status = 1
					WHERE verify_token = '$clicked_token';
				EOF;
				$update_query_run = $db->exec($update_query);

				if($update_query_run)
				{
					$_SESSION['status'] = "ยืนยันอีเมลสำเร็จ";
					header("location: login.php");
					exit();
				}
				else
				{
					$_SESSION['status'] = "ยืนยันไม่สำเร็จ";
					$db->lastErrorMsg();
					header("location: login.php");
					exit();
				}
			}
			else if ($row['verify_status'] == 1)
			{
				$_SESSION['status'] = "ยืนยันอีเมลเรียบร้อยแล้วกรุณาเข้าสู่ระบบ";
				header("location: login.php");
				exit();
			}
		}
		else
		{
			$_SESSION['status'] = "ไม่มี token นี้";
			header("location: login.php");
		}

	}
	else
	{
		$_SESSION['status'] = "ไม่สามารถเข้าถึงได้";
		header("location: index.php");
	}

?>
