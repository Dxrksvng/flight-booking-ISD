<?php
	session_start();
	$page_title = "จัดการที่นั่งและสัมภาระ";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");
	if(isset($_GET['data']))
	{
	$service_data = json_decode($_GET['data']);
	$_SESSION['booking']['service'] = $service_data;

	if(!isset($_SESSION['booking']['passenger']))
	{
		header("location: index.php");
	}

	if(isset($_SESSION['booking']['booking']['ret']))
	{
		$sql_ret = "
		SELECT seat_no FROM passenger
		WHERE flight_id = " . $_SESSION['booking']['booking']['ret']['ret_id'];
		$ret_ret = $db->query($sql_ret);
		$seat_ret_table = [];
		while($row_ret = $ret_ret->fetchArray(SQLITE3_ASSOC))
		{
			array_push($seat_ret_table, $row_ret);
		}

		$seat_num_ret = "SELECT num_of_seat FROM flights
				WHERE flight_id = " . $_SESSION['booking']['booking']['ret']['ret_id'];
		$ret_num_ret = $db->query($seat_num_ret);
		$num_ret = $ret_num_ret->fetchArray(SQLITE3_ASSOC);

	}


	$sql_out = "SELECT seat_no FROM passenger
			WHERE flight_id = " . $_SESSION['booking']['booking']['out']['out_id'];
	$ret_out = $db->query($sql_out);
	$seat_out_table = [];
	while($row_out = $ret_out->fetchArray(SQLITE3_ASSOC))
	{
		array_push($seat_out_table, $row_out);
	}

	$seat_num_out = "SELECT num_of_seat FROM flights
				WHERE flight_id = " . $_SESSION['booking']['booking']['out']['out_id'];
	$ret_num_out = $db->query($seat_num_out);
	$num_out = $ret_num_out->fetchArray(SQLITE3_ASSOC);
	}
	else
	{
		header("location: index.php");
	}
?>
<link rel="stylesheet" href="static/seat.css">

<div class="flex flex-col items-center justify-center bg-gray-100 text-gray-800">
	<div class="border p-4 rounded-md shadow-md bg-white m-5">
			<h1 class="text-3xl font-semibold mb-6 text-left text-color-primary">เพิ่มน้ำหนักสัมภาระ</h1>
			<div class="p-4 space-y-4 h-40 overflow-x-hidden overflow-y-scroll w-auto m-5">

				<?php for($i = 0; $i<$_SESSION['booking']['booking']['pas_num']; $i++){?>
				<div class=" justify-between items-center sm:flex">
					<div class="flex-1 text-center mx-2">
						<h3 class="text-black text-md font-semibold m-4 text-center">คุณ : <?php echo $_SESSION['booking']['passenger'][$i]['firstname']?></h3>
					</div>
					<div class="flex-1 text-center mx-2">
						<h3 class="text-black text-sm font-semibold mb-4">เพิ่มน้ำหนักสัมภาระขาไป</h3>
						<input id="go_lug_<?php echo $i;?>" name="go_lug_<?php echo $i;?>" type="number"
						class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6"
						value=0
						data-index=<?php echo $i;?>
						>
					</div>
					<?php if($_SESSION['booking']['booking']['trip_type'] == "go-2"){?>
					<div class="flex-1 text-center mx-2">
						<h3 class="text-black text-sm font-semibold mb-4">เพิ่มน้ำหนักสัมภาระขากลับ</h3>
						<input id="back_lug_<?php echo $i;?>" name="back_lug_<?php echo $i;?>" type="number"
						class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6"
						value=0
						data-index=<?php echo $i;?>
						>
					</div>
					<?php }?>
				</div>
				<?php } ?>
			</div>
			<div class="text-left text-lg text-red-600 font-semibold">
					ผู้โดยสารสามารถซื้อกระเป๋าสัมภาระล่วงหน้าได้ไม่เกิน 45 กิโลกรัม
			</div>
		</div>
</div>

	<div class="flex flex-col items-center justify-center bg-gray-100 text-gray-800">
		<div class="border p-4 rounded-md bg-white shadow-md m-5 text-center">
		<h1 class="text-3xl font-semibold mb-6 text-left text-color-primary">ที่นั่งขาไป</h1>
			<ul class="showcase">
				<li>
					<div class="seat_out"></div>
					<small>ที่ว่าง</small>
				</li>
				<li>
					<div class="seat_out selected"></div>
					<small>ที่นั่งที่เลือก</small>
				</li>
				<li>
					<div class="seat_out sold"></div>
					<small>ไม่ว่าง</small>
				</li>
			</ul>

			<div class="container_seat_go">
				<div class="row">
					<div class="seat_name"></div>
					<div class="seat_name">A</div>
					<div class="seat_name">B</div>
					<div class="seat_name">C</div>
					<div class="seat_name">D</div>
					<div class="seat_name">E</div>
					<div class="seat_name">F</div>
				</div>
				<div class="scroll">
					<?php
					for($i = 1; $i < ($num_out['num_of_seat']/6) + 1; $i++){
						?>
					<div class="row">
						<div class="seat_number"><?php echo $i;?></div>
						<?php
						$seatLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
						foreach ($seatLetters as $letter) {
							$check = FALSE;
							$seatId = $letter . $i;
							foreach($seat_out_table as $row)
							{
								if($seatId == $row['seat_no'])
								{
									$check = TRUE;
									echo "<button class='seat_out sold' id='$seatId' value='$seatId'></button>";
								}
							}

							if($check != TRUE)
							{
								echo "<button class='seat_out' id='$seatId' value='$seatId'></button>";
							}

						}
						?>
					</div>
					<?php }?>
				</div>
			</div>

			<p id="text_go">
				<h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution1">กรุณาเลือกที่นั่ง</h2>
			</p>
		</div>
	</div>



	<?php if($_SESSION['booking']['booking']['trip_type'] == "go-2"){?>

	<div class="flex flex-col items-center justify-center bg-gray-100 text-gray-800">
		<div class="border p-4 rounded-md shadow-md bg-white m-5 text-center">
		<h1 class="text-3xl font-semibold mb-6 text-left text-color-primary">ที่นั่งขากลับ</h1>
			<ul class="showcase">
				<li>
					<div class="seat_ret"></div>
					<small>ที่ว่าง</small>
				</li>
				<li>
					<div class="seat_ret selected"></div>
					<small>ที่นั่งที่เลือก</small>
				</li>
				<li>
					<div class="seat_ret sold"></div>
					<small>ไม่ว่าง</small>
				</li>
			</ul>

			<div class="container_seat_back">
				<div class="row">
					<div class="seat_name"></div>
					<div class="seat_name">A</div>
					<div class="seat_name">B</div>
					<div class="seat_name">C</div>
					<div class="seat_name">D</div>
					<div class="seat_name">E</div>
					<div class="seat_name">F</div>
				</div>
				<div class="scroll">
					<?php
					for($i = 1; $i < ($num_ret['num_of_seat']/6) + 1; $i++){
						?>
					<div class="row">
						<div class="seat_number"><?php echo $i;?></div>
						<?php
						$seatLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
						foreach ($seatLetters as $letter) {
							$check = FALSE;
							$seatId = $letter . $i;
							foreach($seat_ret_table as $row)
							{
								if($seatId == $row['seat_no'])
								{
									$check = TRUE;
									echo "<button class='seat_ret sold' id='$seatId' value='$seatId'></button>";
								}
							}

							if($check != TRUE)
							{
								echo "<button class='seat_ret' id='$seatId' value='$seatId'></button>";
							}

						}
						?>
					</div>
					<?php }?>
				</div>
			</div>

			<p id="text_back">
				<h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution2">กรุณาเลือกที่นั่ง</h2>
			</p>
		</div>
	</div>
	<?php }?>
	<!-- confirm all -->
		<div class="p-4 rounded-md">
            <div class="flex justify-center mt-4 gap-6 sm:flex flex-col items-center py-2 px-4 md:flex flex-col py-2 px-4 lg:flex flex-col py-2 px-4">
                <button" id="confirm" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full">
                        ยืนยันการเลือก
                </button>
            </div>
        </div>

    <script>
		let seat_no_go = [];
		let seat_no_back = [];

		function update_go(seat_no_go) {
			const selectedSeats = document.querySelectorAll(".row .seat_out.selected");
			const selectedSeatsCount = selectedSeats.length;
			const passengerData = <?php echo json_encode($_SESSION['booking']['passenger']); ?>;

			pass_con_go.innerHTML = "";

			selectedSeats.forEach((seat, index) => {
				const passengerIndex = index;
				const passengerFirstname = passengerData[passengerIndex]['firstname'];
				const seatNumber = seat_no_go[index];
				const passengerElement = document.createElement("p");

				passengerElement.id = index;
				passengerElement.dataset.seat = seatNumber;
				passengerElement.innerText = `คุณ : ${passengerFirstname} ${seatNumber}`;
				pass_con_go.appendChild(passengerElement);
			});

			return selectedSeatsCount;
		}
		function update_back(seat_no_back) {
			const selectedSeats = document.querySelectorAll(".row .seat_ret.selected");
			const selectedSeatsCount = selectedSeats.length;
			const passengerData = <?php echo json_encode($_SESSION['booking']['passenger']); ?>;

			pass_con_back.innerHTML = "";

			selectedSeats.forEach((seat, index) => {
				const passengerIndex = index;
				const passengerFirstname = passengerData[passengerIndex]['firstname'];
				const seatNumber = seat_no_back[index];
				const passengerElement = document.createElement("p");

				passengerElement.id = index;
				passengerElement.dataset.seat = seatNumber;
				passengerElement.innerText = `คุณ : ${passengerFirstname} ${seatNumber}`;
				pass_con_back.appendChild(passengerElement);
			});

			return selectedSeatsCount;
		}

		const container_go = document.querySelector(".container_seat_go");
		const pass_con_go = document.getElementById("text_go");
		container_go.addEventListener("click", (e) => {
			if (e.target.classList.contains("seat_out")
			&& !e.target.classList.contains("selected")
			&& !e.target.classList.contains("sold")
			&& update_go(seat_no_go) < <?php echo $_SESSION['booking']['booking']['pas_num']?>)
			{
				e.target.classList.toggle("selected");
				seat_no_go.push(e.target.value);

				update_go(seat_no_go);
			}
			else if(e.target.classList.contains("selected") && !e.target.classList.contains("sold"))
			{
				e.target.classList.toggle("selected");
				seat_no_go.splice(seat_no_go.indexOf(e.target.value), 1);
				update_go(seat_no_go);
			}
		});


		<?php if($_SESSION['booking']['booking']['trip_type'] == "go-2"){?>
			const container_back = document.querySelector(".container_seat_back");
			const pass_con_back = document.getElementById("text_back");
			container_back.addEventListener("click", (e) => {
			if (e.target.classList.contains("seat_ret")
			&& !e.target.classList.contains("selected")
			&& !e.target.classList.contains("sold")
			&& update_back(seat_no_back) < <?php echo $_SESSION['booking']['booking']['pas_num']?>)
			{
				e.target.classList.toggle("selected");
				seat_no_back.push(e.target.value);

				update_back(seat_no_back);
			}
			else if(e.target.classList.contains("selected") && !e.target.classList.contains("sold"))
			{
				e.target.classList.toggle("selected");
				seat_no_back.splice(seat_no_back.indexOf(e.target.value), 1);
				update_back(seat_no_back);
			}
			});
		<?php }?>


		//prevent minus
		$(document).ready(function() {
			<?php for($i = 0; $i<$_SESSION['booking']['booking']['pas_num']; $i++){?>
			var go_lug_<?php echo $i;?> = $("#go_lug_<?php echo $i;?>");
			var back_lug_<?php echo $i;?> = $("#back_lug_<?php echo $i;?>");
			go_lug_<?php echo $i;?>.on("input", function() {
				let currentValue = parseInt(go_lug_<?php echo $i;?>.val());
				if (currentValue < 1 || isNaN(currentValue)) {
					go_lug_<?php echo $i;?>.val(0);
				}
				if(currentValue > 45){
					go_lug_<?php echo $i;?>.val(45);
				}
			});
			back_lug_<?php echo $i;?>.on("input", function() {
				let currentValue = parseInt(back_lug_<?php echo $i;?>.val());
				if (currentValue < 1 || isNaN(currentValue)) {
					back_lug_<?php echo $i;?>.val(0);
				}
				if(currentValue > 45){
					back_lug_<?php echo $i;?>.val(45);
				}
			});
			<?php }?>
		});
		// send data
        $(document).ready(function() {
			$('#confirm').click(function() {
				var lug = [];
				var seats = [];
				var check_go = false;

				<?php for ($i = 0; $i < $_SESSION['booking']['booking']['pas_num']; $i++) { ?>

					var goLugValue = $('#go_lug_<?php echo $i; ?>').val();

					<?php if ($_SESSION['booking']['booking']['trip_type'] == "go-2") { ?>
						var backLugValue = $('#back_lug_<?php echo $i; ?>').val();
					<?php } ?>
					var lugdata = {
						goLug: goLugValue,
						<?php if ($_SESSION['booking']['booking']['trip_type'] == "go-2") { ?>
							backLug: backLugValue,
						<?php } ?>
					};
					lug.push(lugdata);
				<?php } ?>

				const caution1 = document.getElementById('caution1');
				const caution2 = document.getElementById('caution2');
				var seat_go = $('#text_go').children().length;
				if(seat_go < <?php echo $_SESSION['booking']['booking']['pas_num'];?>)
				{
					caution1.classList.remove('hidden');
				}
				else
				{
					caution1.classList.add('hidden');
					<?php for ($i = 0; $i < $_SESSION['booking']['booking']['pas_num']; $i++) { ?>
						var data_go = $('#text_go #<?php echo $i;?>').data('seat');
						seats.push({seat_go: ["<?php echo $_SESSION['booking']['passenger'][$i]['firstname'];?>", data_go]});
					<?php } ?>
					check_go = true;
				}

				<?php if ($_SESSION['booking']['booking']['trip_type'] == "go-2") { ?>
					var seat_back = $('#text_back').children().length;
					if(seat_back < <?php echo $_SESSION['booking']['booking']['pas_num'];?>)
					{
						caution2.classList.remove('hidden');
					}
					else
					{
						caution2.classList.add('hidden');
						<?php for ($i = 0; $i < $_SESSION['booking']['booking']['pas_num']; $i++) { ?>
							var data_back = $('#text_back #<?php echo $i;?>').data('seat');
							seats.push({seat_back: ["<?php echo $_SESSION['booking']['passenger'][$i]['firstname'];?>", data_back]});
						<?php } ?>
						if(check_go == true)
						{
							var data = JSON.stringify({luggage: lug, seats: seats});
							console.log(data);
							window.location.href = "payment.php?data=" + data;
						}
					}
				<?php }
					else {?>
					if(check_go == true)
						{
							var data = JSON.stringify({luggage: lug, seats: seats});
							console.log(data);
							window.location.href = "payment.php?data=" + data;
						}
				<?php } ?>
			});
		});


	</script>
<?php include("includes/footer.php")?>
