<?php
	session_start();
	$page_title = "รายการและรายละเอียดเที่ยวบิน";
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
	if(isset($_POST['flight_id']))
	{
		$flight_id = $_POST['flight_id'];
		if(!empty($flight_id))
		{
			$pas = "
				SELECT * FROM passenger
				WHERE flight_id=" . $flight_id;
			$query_pas = $db->query($pas);
			$pas_table = [];
			while($row = $query_pas->fetchArray(SQLITE3_ASSOC))
			{
				array_push($pas_table, $row);
			}
			if(empty($pas_table))
			{
					?>
					<div class="mx-16 mt-16 mb-5 m flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
						<h5><?php echo "ไม่พบรายละเอียดเที่ยวบิน"; ?></h5>
					</div>
					<?php
			}
		}
		else {
				?>
				<div class="mx-16 mt-16 mb-5 m flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
					<h5><?php echo "ไม่พบรายละเอียดเที่ยวบิน"; ?></h5>
				</div>
				<?php
			}
	}

?>


<div class="mx-16 mt-16 mb-5 m flex items-center">
	<h2 class="text-center text-2xl font-bold text-gray-900">รายละเอียดเที่ยวบิน</h2>
</div>
<div class="mx-16 mb-16 flex items-center">
	<form action="flight_list.php" method="POST">
    	<input type="number" name="flight_id" class="py-2 px-4 border border-gray-300 rounded-md mr-2 focus:border-gray-600 hover:border-gray-400" placeholder="Flight ID">
    	<button type="submit" class="py-2 px-4 bg-red-500 text-white rounded-md hover:bg-red-700">Search</button>
	</form>
</div>

<?php if(!empty($pas_table)){?>
<div class="flex justify-center h-96 m-16 overflow-auto border border-gray-300 shadow-md rounded-md">
	<table class="text-center min-w-full bg-white">
		<thead class="bg-red-500 text-white">
			<tr>
				<th class="py-2 px-4 border-b">Passenger ID</th>
				<th class="py-2 px-4 border-b">User ID</th>
				<th class="py-2 px-4 border-b">Flight ID</th>
				<th class="py-2 px-4 border-b">เบอร์โทรศัพท์</th>
				<th class="py-2 px-4 border-b">วันเกิด</th>
				<th class="py-2 px-4 border-b">ชื่อจริง</th>
				<th class="py-2 px-4 border-b">นามสกุล</th>
				<th class="py-2 px-4 border-b">Prefix</th>
				<th class="py-2 px-4 border-b">Firstname</th>
				<th class="py-2 px-4 border-b">Lastname</th>
				<th class="py-2 px-4 border-b">สัญชาติ</th>
				<th class="py-2 px-4 border-b">ประกัน</th>
				<th class="py-2 px-4 border-b">อาหาร</th>
				<th class="py-2 px-4 border-b">รถเช่า</th>
				<th class="py-2 px-4 border-b">ที่นั่ง</th>
				<th class="py-2 px-4 border-b">น้ำหนักสัมภาระ</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($pas_table as $row){?>
				<tr>
					<td class="py-2 px-4 border-b"><?php echo $row['passenger_id'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['user_id'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['flight_id'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['phone'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['DOB'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['first_name'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['last_name'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['prefix'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['firstname_eng'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['lastname_eng'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['nationality'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['insurance'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['food'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['car_rent'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['seat_no'];?></td>
					<td class="py-2 px-4 border-b"><?php echo $row['lug'];?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php }?>

<?php include("includes/footer.php")?>

