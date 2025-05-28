<?php
	session_start();
	include('dbcon.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';

	function sendemail_verify($name, $email, $verify_token)
	{
		$mail = new PHPMailer(true);


		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth = true;                                //Enable SMTP authentication
		$mail->Username   = '65070009@kmitl.ac.th';                     //SMTP username
		$mail->Password   = 'sdqmxzopstbueumn';

		$mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom('65070009@kmitl.ac.th', $name);
		$mail->addAddress($email);

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'DATA Airline';

		$email_template = "
			<h2>DATA Airline</h2>
			<h5>เพื่อยืนยันอีเมลคลิ๊กลิ้งด้านล่างนี้</h5>
			<br>
			<a href='http://10.0.15.21/dsba/65070009/App/verify-email.php?token=$verify_token'>คลิ๊กที่นี่</a>
		";

		$mail->Body = $email_template;
		$mail->send();
		// echo 'Message has been sent';
	}

	if (isset($_POST['send'])) {
		$firstname = $_POST['firstname'];
		$firstname_eng = $_POST['firstname_eng'];
		$lastname = $_POST['lastname'];
		$lastname_eng = $_POST['lastname_eng'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$DOB = $_POST['DOB'];
		$verify_token = md5(rand());

		$check_email_query = "SELECT email FROM users WHERE email = '$email'";
		$ret = $db->query($check_email_query);
		$result = $ret->fetchArray(SQLITE3_ASSOC);

		if(!empty($result['email']))
		{
			$_SESSION['status'] = 'มีอีเมลนี้ในระบบแล้ว';
			header('location: register.php');
			exit;
		}
		else
		{
			$insert =<<<EOF
				INSERT INTO users (first_name, firstname_eng, last_name, lastname_eng, phone, email, password, verify_token, DOB, role, verify_status)
				VALUES ('$firstname', '$firstname_eng', '$lastname', '$lastname_eng', '$phone', '$email', '$password', '$verify_token', '$DOB', 'customer', 0);
			EOF;
			$ret_insert = $db->exec($insert);
			// if ($ret_insert === false) {
			// 	echo "Query execution failed: " . $db->lastErrorMsg();
			// } else {
			// 	echo "Query executed successfully. Rows affected: " . $ret_insert;
			// }
			if($ret_insert){
				sendemail_verify("$firstname_eng", "$email", "$verify_token");
				$_SESSION['status'] = "สมัครสมาชิกสำเร็จกรุณายืนยืนอีเมลที่อีเมลของคุณ";
				header("location: register.php");
			}
			else
			{
				$_SESSION['status'] = "สมัครสมาชิกไม่สำเร็จ";
				header("location: register.php");
			}
		}

	}

?>
