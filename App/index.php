<?php
	session_start();
	$page_title = "หน้าหลัก";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");
	$sql ="SELECT * from airports";
    $ret = $db->query($sql);
	$airport_table = [];
	while($row = $ret->fetchArray(SQLITE3_ASSOC))
	{
		array_push($airport_table, $row);
	}
	if(isset($_POST['done']))
	{
		unset($_SESSION['booking']);
	}
?>
<link rel="stylesheet" href="static/error.css">

<div class="error"></div>

	<div id="app" class="max-w-screen-2xl mx-auto px-4 md:px-8 py-12 transition-all duration-500 ease-linear flex flex-col items-center">
		<!-- Carousel -->
		<div class="relative mb-10">
			<div class="slides-container h-96 flex snap-x snap-mandatory sm:overflow-hidden overflow-x-auto space-x-2 rounded scroll-smooth before:w-[20%] before:shrink-0 after:w-[20%] after:shrink-0 md:before:w-0 md:after:w-0">
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/1.png" alt="">
				</div>
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/2.png" alt="">
				</div>
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/3.png" alt="">
				</div>
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/4.png" alt="">
				</div>
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/5.png" alt="">
				</div>
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/6.png" alt="">
				</div>
				<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
					<img class="w-full h-full object-cover" src="picture/7.png" alt="">
				</div>
			</div>

			<div class="absolute top-0 -left-4 h-full items-center hidden md:flex">
				<button role="button" class="prev px-2 py-2 rounded-full bg-neutral-100 text-neutral-900 group" aria-label="prev"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-active:-translate-x-2 transition-all duration-200 ease-linear">
						<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
					</svg>
				</button>
			</div>
			<div class="absolute top-0 -right-4 h-full items-center hidden md:flex">
				<button role="button" class="next px-2 py-2 rounded-full bg-neutral-100 text-neutral-900 group" aria-label="next"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-active:translate-x-2 transition-all duration-200 ease-linear">
						<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
					</svg>
				</button>
			</div>
		</div>

		<!-- search -->

		<div class="bg-white rounded-md p-4 w-full max-w-xl shadow-lg">
			<?php
				if (isset($_SESSION['status'])) {
					?>
					<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
						<h5><?php echo $_SESSION['status']; ?></h5>
					</div>
					<?php unset($_SESSION['status']);
				}
			?>
			<form  id="search_form" action="search_code.php" method="POST" novalidate>
				<div class="mb-4">
					<p class="text-lg text-gray-500">เลือกเที่ยวบิน</p>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
					<div class="flex-grow">
						<label for="goes" class="text-sm text-gray-600">ประเภทเที่ยวบิน</label>
						<select id="goes" name="goes" class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
							<option selected disabled>กรุณาเลือกประเภทเที่ยวบิน</option>
							<option value="go-1">เที่ยวเดียว</option>
							<option value="go-2">ไป-กลับ</option>
						</select>
					</div>

					<div class="flex-grow">
						<label for="total-count" class="text-sm text-gray-600">จำนวนผู้โดยสาร</label>
						<input id="pas_num" name="pas_num" type="number" class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
					</div>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
					<div class="flex-grow">
						<label for="from" class="text-sm text-gray-600">ต้นทาง</label>
						<select id="from" name="from" class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
							<option selected disabled>กรุณาเลือกต้นทาง</option>
							<?php
								foreach($airport_table as $row){?>
								<option value="<?php echo $row['airport_code'];?>"><?php echo $row['airport_code'] . ' ' . $row['airport_name'];?></option>
							<?php
								}
							?>
						</select>
					</div>
					<div class="flex-grow">
						<label for="to" class="text-sm text-gray-600">ปลายทาง</label>
						<select id="to" name="to" class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
							<option selected disabled>กรุณาเลือกต้นทาง</option>
							<?php
								foreach($airport_table as $row){?>
								<option value="<?php echo $row['airport_code'];?>"><?php echo $row['airport_code'] . ' ' . $row['airport_name'];?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
				<div class="mt-4 flex-grow">
					<label for="date" class="text-sm text-gray-600">วันที่ออกเดินทาง</label>
					<input type="date" id="date" name="date"
						class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
				</div>
				<div class="mt-4 flex-grow hidden" id="return-date">
					<label for="return" class="text-sm text-gray-600">วันที่เดินทางกลับ</label>
					<input type="date" id="return" name="return"
						class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
				</div>

				<button name="search" type="submit" id="search-button" class="w-full mt-4 p-2 rounded-md bg-red-700 text-white hover:bg-red-800">
					ค้นหา
				</button>
			</form>

		</div>
	</div>

	<script src="static/script.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>


<?php include("includes/footer.php");?>
