<?php
	session_start();
	$page_title = "ออกตั๋ว";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");

	if(!isset($_SESSION['booking']))
	{
		header("location: index.php");
		exit();
	}

	if(isset($_GET['data']))
	{
		$amount = json_decode($_GET['data']);
		$_SESSION['ticket'] = json_decode($_GET['data']);
	}
	else
	{
		$amount = $_SESSION['ticket'];
	}

	$booking = $_SESSION['booking']['booking'];
	// print_r($booking);
	$sql_airport ="SELECT * from airports";
    $ret = $db->query($sql_airport);
	$pass = $_SESSION['finish'];
	$airport_table = [];
		while($row = $ret->fetchArray(SQLITE3_ASSOC))
		{
			if($row['airport_code'] == $booking['out']['out_origin'])
			{
				$airport_table['out_origin'] = $row['airport_name'];
			}
			if($row['airport_code'] == $booking['out']['out_dest'])
			{
				$airport_table['out_dest'] = $row['airport_name'];
			}
			if($booking['trip_type'] == 'go-2'){
				if($row['airport_code'] == $booking['ret']['ret_origin'])
				{
					$airport_table['ret_origin'] = $row['airport_name'];
				}
				if($row['airport_code'] == $booking['ret']['ret_dest'])
				{
					$airport_table['ret_dest'] = $row['airport_name'];
				}
			}
		}
	$sql_gate_go ="SELECT gate from flights
				WHERE flight_id ='" .$booking['out']['out_id']. "'";
	$ret_go = $db->query($sql_gate_go);
	$gate_go = $ret_go->fetchArray(SQLITE3_ASSOC);
	if($booking['trip_type'] == 'go-2'){
		$sql_gate_back ="SELECT gate from flights
				WHERE flight_id ='" .$booking['ret']['ret_id']. "'";
		$ret_back = $db->query($sql_gate_back);
		$gate_back = $ret_back->fetchArray(SQLITE3_ASSOC);
	}

	// print_r($_SESSION['finish']);
	// print_r(implode(', ', (array) $_SESSION['booking']['service']->car_rent));
	if(isset($_SESSION['user_id']))
	{
		$user_id = $_SESSION['user_id'];
		for($i = 0; $i < $booking['pas_num']; $i++)
		{

			$insert_out ="
			INSERT INTO passenger (user_id, flight_id, phone,
			DOB, first_name, last_name,
			firstname_eng, lastname_eng,
			prefix, nationality, insurance,
				food, car_rent, seat_no, lug)
			VALUES ($user_id, ". $pass[$i]['out_id'] . ", '". $pass[$i]['phone']."',
					'".$pass[$i]['DOB']."', '".$pass[$i]['firstname']."','".$pass[$i]['lastname']."',
					'".$pass[$i]['fisrtname_eng']."', '".$pass[$i]['lastname_eng']."',
					'".$pass[$i]['prefix']."','".$pass[$i]['nationality']."', '".$pass[$i]['insurance']."',
					'".implode(', ', $pass[$i]['food'])."','".implode(', ', (array) $_SESSION['booking']['service']->car_rent)."',
					'".$pass[$i]['seat_go']."', '".$pass[$i]['goLug']."');
			";
			$ret_out = $db->exec($insert_out);
			if($booking['trip_type'] == 'go-2')
			{
				$insert_ret ="
				INSERT INTO passenger (user_id, flight_id, phone,
				DOB, first_name, last_name,
				firstname_eng, lastname_eng,
				prefix, nationality, insurance,
					food, car_rent, seat_no, lug)
				VALUES ($user_id, ". $pass[$i]['ret_id'] . ", '". $pass[$i]['phone']."',
						'".$pass[$i]['DOB']."', '".$pass[$i]['firstname']."','".$pass[$i]['lastname']."',
						'".$pass[$i]['fisrtname_eng']."', '".$pass[$i]['lastname_eng']."',
						'".$pass[$i]['prefix']."','".$pass[$i]['nationality']."', '".$pass[$i]['insurance']."',
						'".implode(', ', $pass[$i]['food'])."','".implode(', ', (array) $_SESSION['booking']['service']->car_rent)."',
						'".$pass[$i]['seat_back']."', '".$pass[$i]['goLug']."');
				";
				$ret_ret = $db->exec($insert_ret);
			}
			// echo $insert_out;
			// echo $insert_ret;
		}
		$pass_id = "
				SELECT passenger_id FROM passenger
				WHERE user_id =" . $user_id;
		$query_id = $db->query($pass_id);
		$pass_id = [];
		while($row = $query_id->fetchArray(SQLITE3_ASSOC))
		{
			array_push($pass_id, $row);
		}
		// print_r($pass_id);
		foreach($pass_id as $id)
		{
			$payment = "
					INSERT INTO payment (user_id, passenger_id, method, amount)
					VALUES ($user_id, ".$id['passenger_id'].", '".$amount->method."', ".$amount->amount.");";
			$ret_pay = $db->exec($payment);
		}

	}
	else
	{
		for($i = 0; $i < $booking['pas_num']; $i++)
		{
			$insert_out ="
			INSERT INTO passenger (flight_id, phone,
			DOB, first_name, last_name,
			firstname_eng, lastname_eng,
			prefix, nationality, insurance,
				food, car_rent, seat_no, lug)
			VALUES (". $pass[$i]['out_id'] . ", '". $pass[$i]['phone']."',
					'".$pass[$i]['DOB']."', '".$pass[$i]['firstname']."','".$pass[$i]['lastname']."',
					'".$pass[$i]['fisrtname_eng']."', '".$pass[$i]['lastname_eng']."',
					'".$pass[$i]['prefix']."','".$pass[$i]['nationality']."', '".$pass[$i]['insurance']."',
					'".implode(', ', $pass[$i]['food'])."','".implode(', ', (array) $_SESSION['booking']['service']->car_rent)."',
					'".$pass[$i]['seat_go']."', '".$pass[$i]['goLug']."');
			";
			$ret_out = $db->exec($insert_out);
			if($booking['trip_type'] == 'go-2')
			{
				$insert_ret ="
				INSERT INTO passenger (flight_id, phone,
				DOB, first_name, last_name,
				firstname_eng, lastname_eng,
				prefix, nationality, insurance,
					food, car_rent, seat_no, lug)
				VALUES (". $pass[$i]['ret_id'] . ", '". $pass[$i]['phone']."',
						'".$pass[$i]['DOB']."', '".$pass[$i]['firstname']."','".$pass[$i]['lastname']."',
						'".$pass[$i]['fisrtname_eng']."', '".$pass[$i]['lastname_eng']."',
						'".$pass[$i]['prefix']."','".$pass[$i]['nationality']."', '".$pass[$i]['insurance']."',
						'".implode(', ', $pass[$i]['food'])."','".implode(', ', (array) $_SESSION['booking']['service']->car_rent)."',
						'".$pass[$i]['seat_back']."', '".$pass[$i]['goLug']."');
				";
				$ret_ret = $db->exec($insert_ret);
			}
			// echo $insert_out;
			// echo $insert_ret;
		}

		$pass_id_out = "
				SELECT passenger_id FROM passenger
				WHERE flight_id =" . $booking['out']['out_id'];
		// print_r($booking);
		$query_id = $db->query($pass_id_out);
		$pass_id_out = [];
		while($row = $query_id->fetchArray(SQLITE3_ASSOC))
		{
			array_push($pass_id_out, $row);
		}
		// print_r($pass_id_out);
		foreach($pass_id_out as $id)
		{
			$payment_out = "
					INSERT INTO payment (passenger_id, method, amount)
					VALUES (".$id['passenger_id'].", '".$amount->method."', ".$amount->amount.");";
			$out_pay = $db->exec($payment_out);
		}

		if($booking['trip_type'] == 'go-2')
		{
			$pass_id_ret = "
				SELECT passenger_id FROM passenger
				WHERE  flight_id =" . $booking['ret']['ret_id'];
			$query_id = $db->query($pass_id_ret);
			$pass_id_ret = [];
			while($row = $query_id->fetchArray(SQLITE3_ASSOC))
			{
				array_push($pass_id_ret, $row);
			}
			// print_r($pass_id_ret);
			foreach($pass_id_ret as $id)
			{
				$payment_ret = "
						INSERT INTO payment (passenger_id, method, amount)
						VALUES (".$id['passenger_id'].", '".$amount->method."', ".$amount->amount.");";
				$ret_pay = $db->exec($payment_ret);
			}

		}
	}
?>

<div class="w-screen h-screen flex flex-col">
	<?php for($i=0; $i < $_SESSION['booking']['booking']['pas_num']; $i++){?>
		<section class="w-full flex-grow flex items-center justify-center p-4">
			<div class="flex w-full max-w-3xl text-zinc-900 h-64">

				<div class="h-full bg-white flex items-center justify-center px-8 rounded-l-3xl flex flex-col shadow-md">
						<img src="picture/logo.png" class="w-36 h-auto mb-2" alt="">
						<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?php echo print_r($pass[$i]);?>" class="w-36 h-auto" alt="">
				</div>

				<div class="relative h-full flex flex-col items-center border-dashed justify-between border-2 bg-white border-gray-500">
					<div class="absolute rounded-full w-8 h-8 bg-gray-100 -top-5"></div>
					<div class="absolute rounded-full w-8 h-8 bg-gray-100 -bottom-5"></div>
				</div>
				<div class="h-full py-8 px-10 bg-white flex-grow rounded-r-3xl flex flex-col shadow-md">
					<div class="flex w-full justify-between items-center">
						<div class="flex flex-col items-center">
							<span class="text-4xl font-bold"><?php echo $booking['out']['out_origin']?></span>
							<span class="text-zinc-500 text-sm"><?php echo $airport_table['out_origin']?></span>
						</div>
						<div class="flex flex-col flex-grow items-center px-10">
							<span class="font-bold text-xs"><?php echo $booking['out']['out_id']?></span>
							<div class="w-full flex items-center mt-2">
								<div class="w-3 h-3 rounded-full border-2 border-zinc-900"></div>
								<div class="flex-grow border-t-2 border-zinc-400 border-dotted h-px"></div>
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mx-2">
									<path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
								</svg>
								<div class="flex-grow border-t-2 border-zinc-400 border-dotted h-px"></div>
								<div class="w-3 h-3 rounded-full border-2 border-zinc-900"></div>
							</div>
							<div class="flex items-center px-3 rounded-full bg-lime-400 h-8 mt-2">
								<span class="text-sm"><?php echo $booking['out']['out_dep'];?> ถึง <?php echo $booking['out']['out_arv']?></span>
							</div>
						</div>
						<div class="flex flex-col items-center">
							<span class="text-4xl font-bold"><?php echo $booking['out']['out_dest']?></span>
							<span class="text-zinc-500 text-sm"><?php echo $airport_table['out_dest']?></span>
						</div>
					</div>
					<div class="flex w-full mt-auto justify-between">
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">วันที่ออกเดินทาง</span>
							<span class="font-mono"><?php echo $booking['out']['date_out']?></span>
						</div>
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">เวลาที่ออกเดินทาง</span>
							<span class="font-mono"><?php echo $booking['out']['out_dep'];?></span>
						</div>
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">ผู้โดยสาร</span>
							<span class="font-mono"><?php echo $pass[$i]['firstname'];?></span>
						</div>
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">Gate/Seat</span>
							<span class="font-mono"><?php echo $gate_go['gate'];?>/<?php echo $pass[$i]['seat_go'];?></span>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php if($_SESSION['booking']['booking']['trip_type'] == 'go-2'){?>
		<section class="w-full flex-grow flex items-center justify-center p-4">
			<div class="flex w-full max-w-3xl text-zinc-900 h-64">

				<div class="h-full bg-white flex items-center justify-center px-8 rounded-l-3xl flex flex-col shadow-md">
						<img src="picture/logo.png" class="w-36 h-auto mb-2" alt="">
						<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?php echo print_r($pass[$i]);?>" class="w-36 h-auto" alt="">
				</div>

				<div class="relative h-full flex flex-col items-center border-dashed justify-between border-2 bg-white border-gray-500">
					<div class="absolute rounded-full w-8 h-8 bg-gray-100 -top-5"></div>
					<div class="absolute rounded-full w-8 h-8 bg-gray-100 -bottom-5"></div>
				</div>
				<div class="h-full py-8 px-10 bg-white flex-grow rounded-r-3xl flex flex-col shadow-md">
					<div class="flex w-full justify-between items-center">
						<div class="flex flex-col items-center">
							<span class="text-4xl font-bold"><?php echo $booking['ret']['ret_origin']?></span>
							<span class="text-zinc-500 text-sm"><?php echo $airport_table['ret_origin']?></span>
						</div>
						<div class="flex flex-col flex-grow items-center px-10">
							<span class="font-bold text-xs"><?php echo $booking['ret']['ret_id']?></span>
							<div class="w-full flex items-center mt-2">
								<div class="w-3 h-3 rounded-full border-2 border-zinc-900"></div>
								<div class="flex-grow border-t-2 border-zinc-400 border-dotted h-px"></div>
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mx-2">
									<path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
								</svg>
								<div class="flex-grow border-t-2 border-zinc-400 border-dotted h-px"></div>
								<div class="w-3 h-3 rounded-full border-2 border-zinc-900"></div>
							</div>
							<div class="flex items-center px-3 rounded-full bg-lime-400 h-8 mt-2">
								<span class="text-sm"><?php echo $booking['ret']['ret_dep'];?> ถึง <?php echo $booking['ret']['ret_arv']?></span>
							</div>
						</div>
						<div class="flex flex-col items-center">
							<span class="text-4xl font-bold"><?php echo $booking['ret']['ret_dest']?></span>
							<span class="text-zinc-500 text-sm"><?php echo $airport_table['ret_dest']?></span>
						</div>
					</div>
					<div class="flex w-full mt-auto justify-between">
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">วันที่ออกเดินทาง</span>
							<span class="font-mono"><?php echo $booking['ret']['date_return']?></span>
						</div>
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">เวลาที่ออกเดินทาง</span>
							<span class="font-mono"><?php echo $booking['ret']['ret_dep'];?></span>
						</div>
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">ผู้โดยสาร</span>
							<span class="font-mono"><?php echo $pass[$i]['firstname'];?></span>
						</div>
						<div class="flex flex-col">
							<span class="text-xs text-zinc-400">Gate/Seat</span>
							<span class="font-mono"><?php echo $gate_back['gate'];?>/<?php echo $pass[$i]['seat_go'];?></span>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php }?>
	<?php }?>
	<div class="p-4 rounded-md">
        <div class="flex justify-center sm:flex flex-col items-center py-2 px-4 md:flex flex-col py-2 px-4 lg:flex flex-col py-2 px-4">
            <button" id="confirm" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full">
                    print
            </button>
        </div>
        <div class="flex justify-center mt-4 gap-6 sm:flex flex-col items-center py-2 px-4 md:flex flex-col py-2 px-4 lg:flex flex-col py-2 px-4">
			<form action="index.php" method="POST">
				<button type="submit" name="done" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full">เสร็จสิ้น</button>
			</form>
        </div>
    </div>
	<?php include("includes/footer.php")?>
</div>
	<script>
        const printBtn = document.querySelector('#confirm');
        printBtn.addEventListener('click', () => window.print());
    </script>

