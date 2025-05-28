<?php
	session_start();
	$page_title = "จัดการเที่ยวบิน";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");
	$flight_table = [];
	$sql_flight = "SELECT * FROM flights";
	$ret_flight = $db->query($sql_flight);
	while($row = $ret_flight->fetchArray(SQLITE3_ASSOC))
	{
		array_push($flight_table, $row);
	}
	if(!isset($_SESSION['authenticated']))
	{
		header("location: index.php");
	}
?>

<div class="mx-16 mt-16 mb-5 m flex items-center">
	<h2 class="text-center text-2xl font-bold text-gray-900">รายการเที่ยวบิน</h2>
</div>
<div class="flex justify-center h-96 mx-16 overflow-auto border border-gray-300 shadow-md rounded-md">

	<table class="text-center min-w-full bg-white">
		<thead class="bg-red-500 text-white">
			<tr>
				<th class="py-2 px-4 border-b">Flight ID</th>
				<th class="py-2 px-4 border-b">ต้นทาง</th>
				<th class="py-2 px-4 border-b">ปลายทาง</th>
				<th class="py-2 px-4 border-b">วันที่ออกเดินทาง</th>
				<th class="py-2 px-4 border-b">เวลาออกเดินทาง</th>
				<th class="py-2 px-4 border-b">เวลาถึง</th>
				<th class="py-2 px-4 border-b">จำนวนที่นั่ง</th>
				<th class="py-2 px-4 border-b">ราคา</th>
				<th class="py-2 px-4 border-b">Gate</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($flight_table as $row){?>
				<tr>
					<td class="py-2 px-4 border-b"><?php echo $row['flight_id'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['origin'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['destination'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['depart_date'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['depart_time'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['arrive_time'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['num_of_seat'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['price'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['gate'];?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>


<?php
	$sql ="SELECT * from airports";
    $ret = $db->query($sql);
	$airport_table = [];
	while($row = $ret->fetchArray(SQLITE3_ASSOC))
	{
		array_push($airport_table, $row);
	}

	if(isset($_POST['update']))
	{
		if (empty($_POST['flight_id'])) {
			?>
				<div class="mx-16 mt-16 mb-5 m flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
					<h5><?php echo "แก้ไขไม่สำเร็จ"; ?></h5>
				</div>
			<?php
		}
		else
		{
			$flight_id = $_POST['flight_id'];
			$origin = $_POST['from'];
			$destination = $_POST['to'];
			$date_out = $_POST['date_out'];
			$out_time = $_POST['out_time'];
			$arv_time = $_POST['arv_time'];
			$num_seat = $_POST['num_seat'];
			$price = $_POST['price'];
			$gate = $_POST['gate'];
			$update = "
					UPDATE flights
					SET
						origin = '$origin',
						destination = '$destination',
						depart_date = '$date_out',
						depart_time = '$out_time',
						arrive_time = '$arv_time',
						num_of_seat = $num_seat,
						price = $price,
						gate = '$gate'
					WHERE flight_id = $flight_id
				";
			$query = $db->exec($update);
		}
	}

	if(isset($_POST['add']))
	{
		if (empty($_POST['from'])) {
			?>
				<div class="mx-16 mt-16 mb-5 m flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
					<h5><?php echo "เพิ่มเที่ยวบินไม่สำเร็จ"; ?></h5>
				</div>
			<?php
		}
		else
		{
			$origin = $_POST['from'];
			$destination = $_POST['to'];
			$date_out = $_POST['date_out'];
			$out_time = $_POST['out_time'];
			$arv_time = $_POST['arv_time'];
			$num_seat = $_POST['num_seat'];
			$price = $_POST['price'];
			$gate = $_POST['gate'];
			$insert = "
			INSERT INTO flights (origin,destination, depart_date,
			depart_time, arrive_time, num_of_seat,
			price, gate)
			VALUES ('$origin', '$destination', '$date_out',
					'$out_time', '$arv_time', $num_seat,
					$price, '$gate')
			";
			$query = $db->exec($insert);
		}
	}

?>



<div class="mx-16 mt-16 mb-5 m flex items-center">
	<h2 class="text-center text-2xl font-bold text-gray-900">จัดการเที่ยวบิน</h2>
</div>

<div class="mx-16 mb-16 items-center">
	<form action="manager.php" method="POST">
		<button type="submit" name="add_flight" class="py-2 px-4 bg-red-500 text-white rounded-md hover:bg-red-700 ml-2">เพิ่ม</button>
		<button type="submit" name="update_flight" class="py-2 px-4 bg-red-500 text-white rounded-md hover:bg-red-700 ml-2">แก้ไข</button>
	</form>
</div>


<?php if(isset($_POST['add_flight'])){?>
<div class="mx-16 mt-16 mb-5 m flex items-center">
	<h2 class="text-center text-2xl font-bold text-gray-900">เพิ่มเที่ยวบิน</h2>
</div>
<div class="mx-16 mb-16 items-center">
	<form action="manager.php" method="POST">

		<div class="flex m-2">


				<select id="from" name="from" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
					<option selected disabled>กรุณาเลือกต้นทาง</option>
						<?php
							foreach($airport_table as $row){?>
							<option value="<?php echo $row['airport_code'];?>"><?php echo $row['airport_code'] . ' ' . $row['airport_name'];?></option>
						<?php
							}
						?>
				</select>

				<select id="to" name="to" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
							<option selected disabled>กรุณาเลือกปลายทาง</option>
							<?php
								foreach($airport_table as $row){?>
								<option value="<?php echo $row['airport_code'];?>"><?php echo $row['airport_code'] . ' ' . $row['airport_name'];?></option>
							<?php
								}
							?>
						</select>

		</div>

		<div class="flex m-2">
			<label for="date_out" class="py-2 px-4">วันที่ออกเดินทาง</label>
			<input type="date" id="date_out" name="date_out" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
		</div>

		<div class="flex m-2">
			<label for="out_time" class="py-2 px-4">เวลาออกเดินทาง</label>
			<input type="time" id="out_time" name="out_time" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
		</div>
		<div class="flex m-2">
			<label for="arv_time" class="py-2 px-4">เวลาถึง</label>
			<input type="time" id="arv_time" name="arv_time" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
		</div>
		<div class="flex m-2">
			<label for="num_seat" class="py-2 px-4">จำนวนที่นั่ง</label>
			<select name="num_seat" id="num_seat" class="w-48 py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
				<option value="240">240</option>
			</select>
		</div>
		<div class="flex m-2">
			<input type="number" name="price" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400" placeholder="ราคา">
			<input type="text" name="gate" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400" placeholder="Gate">
		</div>
		<button type="submit" name="add" class="py-2 px-4 bg-red-500 text-white rounded-md hover:bg-red-700 ml-2">เพิ่มเที่ยวบิน</button>
	</form>
</div>
<?php }?>

<?php if(isset($_POST['update_flight'])){?>
<div class="mx-16 mt-16 mb-5 m flex items-center">
	<h2 class="text-center text-2xl font-bold text-gray-900">แก้ไขเที่ยวบิน</h2>
</div>
<div class="mx-16 mb-16 items-center">
	<form action="manager.php" method="POST">
		<div class="flex m-2">
			<input type="number" name="flight_id" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400" placeholder="Flight ID">
		</div>

		<div class="flex m-2">


				<select id="from" name="from" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
					<option selected disabled>กรุณาเลือกต้นทาง</option>
						<?php
							foreach($airport_table as $row){?>
							<option value="<?php echo $row['airport_code'];?>"><?php echo $row['airport_code'] . ' ' . $row['airport_name'];?></option>
						<?php
							}
						?>
				</select>

				<select id="to" name="to" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
							<option selected disabled>กรุณาเลือกปลายทาง</option>
							<?php
								foreach($airport_table as $row){?>
								<option value="<?php echo $row['airport_code'];?>"><?php echo $row['airport_code'] . ' ' . $row['airport_name'];?></option>
							<?php
								}
							?>
						</select>

		</div>


		<div class="flex m-2">
			<label for="date_out" class="py-2 px-4">วันที่ออกเดินทาง</label>
			<input type="date" id="date_out" name="date_out" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
		</div>
		<div class="flex m-2">
			<label for="out_time" class="py-2 px-4">เวลาออกเดินทาง</label>
			<input type="time" id="out_time" name="out_time" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
		</div>
		<div class="flex m-2">
			<label for="arv_time" class="py-2 px-4">เวลาถึง</label>
			<input type="time" id="arv_time" name="arv_time" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
		</div>
		<div class="flex m-2">
			<label for="num_seat" class="py-2 px-4">จำนวนที่นั่ง</label>
			<select name="num_seat" id="num_seat" class="w-48 py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400">
				<option value="240">240</option>
			</select>
		</div>
		<div class="flex m-2">
			<input type="number" name="price" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400" placeholder="ราคา">
			<input type="text" name="gate" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400" placeholder="Gate">
		</div>
		<button type="submit" name="update" class="py-2 px-4 bg-red-500 text-white rounded-md hover:bg-red-700 ml-2">แก้ไขเที่ยวบิน</button>
	</form>

</div>
<?php }?>

<?php include("includes/footer.php")?>
