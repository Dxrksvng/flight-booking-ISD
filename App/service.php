<?php
    header('Cache-Control: no cache');
    session_cache_limiter('private_no_expire');
	session_start();
	$page_title = "บริการเสริม";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");
	$passenger = [];
    if(isset($_SESSION['booking']))
    {
	for ($i = 1; $i < $_SESSION['booking']['booking']['pas_num'] + 1; $i++) {
		$temp = array(
			"prefix" => $_POST["prefix_$i"],
			"firstname" => $_POST["firstname_$i"],
			"lastname" => $_POST["lastname_$i"],
			"firstname_eng" => $_POST["firstname_eng_$i"],
			"lastname_eng" => $_POST["lastname_eng_$i"],
			"email" => $_POST["email_$i"],
			"phone" => $_POST["phone_$i"],
			"DOB" => $_POST["DOB_$i"],
			"nationality" => $_POST["nationality_$i"]
		);
		$passenger[] = $temp;
	}
    $_SESSION['booking']['passenger'] = $passenger;
    }
    else
    {
        header("location: index.php");
    }

?>

<div class="flex justify-center mt-10">
    <div class=" w-10/12">
            <h2 class="text-2xl font-bold mb-6">เลือกประกันการเดินทาง</h2>

            <!--service-->
            <div class="border p-4 rounded-md shadow-md bg-white">
                <!-- carousel -->
				<div class="relative mb-10">
						<div style="height: 500px;" class="slides-container h-96 flex snap-x snap-mandatory sm:overflow-hidden overflow-x-auto space-x-2 rounded scroll-smooth before:w-[20%] before:shrink-0 after:w-[20%] after:shrink-0 md:before:w-0 md:after:w-0">
							<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
								<img class=" h-full max-w-auto" src="picture/insurance.png" alt="" class="w-3/3 aspect-w-1">
							</div>
							<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
								<img class=" h-full max-w-auto" src="picture/insurance_price.png" alt="" class="w-3/3 aspect-w-1">
							</div>
							<div class="slide h-full flex-shrink-0 snap-center rounded overflow-hidden">
								<img class=" h-full max-w-auto" src="picture/insurance_des.png" alt="" class="w-3/3 aspect-w-1">
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

                <!-- add detail button -->
                <div class="flex justify-center mt-4">
                    <button class="bg-white hover:bg-red-500 hover:text-white border text-red-500 border-red-500  py-2 px-4 rounded-xl"
                        onclick="showAdditionalDetails()">
                        แสดงรายละเอียดเพิ่มเติม
                    </button>
                </div>

                <!-- Additional details and conditions -->
                <div id="additionalDetails" class="hidden mt-4 mx-10 my-10">

                <!-- text condition -->
                    <div class="text">
                        <p>เงื่อนไขและรายละเอียดความคุ้มครอง</p>
                        <p>1. สงวนสิทธิ์รับประกันภัยโดยผู้เอาประกันภัยต้องมีอายุตั้งแต่ 1 เดือน - 85 ปี</p>
                        <p>2. สำหรับแผนคนเดียวผู้สมัครทำประกันภัยจะต้องมีอายุ
                            ไม่ต่ำกว่า 1 เดือน และไม่เกิน 85 ปี
                            ณ วันที่เริ่มเดินทาง ทั้งนี้หากผู้สมัครมีอายุต่ำกว่า 18 ปี
                            กรุณาติดต่อเจ้าหน้าที่บริการลูกค้าสัมพันธ์เพื่อสมัครประกันภัย</p>
                        <p>3. สำหรับแผนครอบครัว คุ้มครองผู้เอาประกันภัยและคู่สมรส และบุตรที่ร่วมเดินทาง ให้ความคุ้มครองบุตร
                            สูงสุด 2 ท่าน (อายุ 2-21 ปี) ทั้งนี้ทุกคนจะได้รับความคุ้มครองเท่ากัน</p>
                        <p>4. สำหรับแผนกลุ่มหรือหมู่คณะ คุ้มครองตั้งแต่ 1 ท่าน ถึงสูงสุด 9 ท่าน
                            โดยผู้สมัครทำประกันภัยจะต้องมีอายุไม่ต่ำกว่า 1 เดือน และ ไม่เกิน 85 ปี ณ วันที่เริ่มเดินทาง
                            ทั้งนี้ จำเป็นต้องมีผู้สมัครอายุ 18 ปีขึ้นไป ถึง 85 ปีอย่างน้อย 1 ท่าน</p>
                        <p>5. ผู้เอาประกันภัยยินยอมและอนุญาตให้สถานพยาบาลทุกชนิด เช่น โรงพยาบาล คลินิก
                            เจ้าหน้าที่ของบริษัทประกันภัยหรือองค์กรที่เกี่ยวข้องเปิดเผยข้อมูลให้กับบริษัท ทูนประกันภัย จำกัด
                            (มหาชน) เมื่อมีการเรียกร้องขอข้อมูลเกี่ยวกับผู้เอาประกันภัย</p>
                    </div>


                    <!-- price -->
                    <div class="flex justify-center mt-4 gap-10 sm:flex flex-col items-start py-1 px-1 md:flex flex-col py-1 px-1 lg:flex flex-col py-1 px-1">

                        <?php if($_SESSION['booking']['booking']['pas_num'] == 1) {?>
                        <div>
                            <div class="flex flex-col">
                                <div class="mb-3">
                                    <label for="male" class="mr-5">แผนคนเดียว 249 THB</label>
                                    <input type="radio" name="single" onclick="selectPlan('แผนคนเดียว', 249)" class="mr-2">

                                </div>

                                <div>
                                    <label for="female">ไม่เป็นไร, ขอบคุณ</label>
                                    <input type="radio" name="single" onclick="clearSelectedPlan()" class="mr-2">

                                </div>

                            </div>
                        </div>
                        <?php }?>
                        <?php if($_SESSION['booking']['booking']['pas_num'] >= 2 and $_SESSION['booking']['booking']['pas_num'] <= 4) {?>
                        <div>
                            <div class="flex flex-col">
                                <label for="male" class="mr-5"> แผนครอบครัว (2 - 5) คน 599 THB</label>
                                <input type="radio" name="family" onclick="selectPlan('แผนครอบครัว', 599)"  class="mr-2">

                                <label for="female">ไม่เป็นไร, ขอบคุณ</label>
                                <input type="radio" name="family" onclick="clearSelectedPlan()" class="mr-2">

                            </div>
                        </div>
                        <?php }?>
                        <?php if($_SESSION['booking']['booking']['pas_num'] > 4) {?>
                        <div>
                            <div class="flex flex-col">
                                <label for="male" class="mr-5">แผนกลุ่ม (4 คนขึ้นไป) 999 THB</label>
                                <input type="radio" name="group" onclick="selectPlan('แผนกลุ่มหรือหมู่คณะ', 999)"  class="mr-2">


                                <label for="female">ไม่เป็นไร, ขอบคุณ</label>
                                <input type="radio" name="group" onclick="clearSelectedPlan()" class="mr-2">

                            </div>
                        </div>
                        <?php }?>
                    </div>

                    <!-- del -->
                    <!-- <div class="flex justify-center mt-4">
                        <div class="max-w-md p-4 bg-white rounded-lg bg-white bg-white shadow-md w-full sm:w-2/3">
                            <h2 class="text-lg font-bold mb-2 text-center ">สรุปรายการ</h2>
                            <div class="text-xl font-semibold mb-2 text-center text-green-600" id="selectedPlan"></div>
                            <div id="totalPrice" class="text-center font-bold mt-4">ราคาทั้งหมด: 0 THB</div>
                            <div class="flex justify-center mt-4 gap-6 sm:items-center py-1 px-1 md:py-1 px-1 lg:py-1 px-1">
                                <button onclick="clearSelectedPlan()" id="clearPlanButton"
                                        class="bg-red-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full">
                                    ลบ
                                </button>
                            </div>
                        </div>
                    </div> -->

                </div>

            </div>

            <!-- food -->
            <h2 class="text-2xl font-bold my-10 mx-10">เลือกอาหารล่วงหน้า</h2>

            <!-- foode -->
            <div class="border p-4 rounded-md bg-white shadow-md">
                <h2 class="text-xl font-bold">รายการอาหาร</h2>
                <div class="text-gray-600 mb-2">เพิ่มอาหารระหว่างการเดินทางของคุณ

                    <div class="flex justify-center mt-4">
                            <div class="max-w-md p-4 bg-white rounded-lg bg-white shadow-md w-full sm:w-2/3">
                                <h2 class="text-lg font-bold mb-2 text-center">สรุปรายการ</h2>
                                <h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution">กรุณาเลือกผู้โดยสาร</h2>
                                <select id="users" name="users" class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3 block w-full rounded-md border-0 py-1.5 text-gray-900  bg-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6" required>
                                    <option value="" selected disabled>กรุณาเลือกผู้โดยสารสำหรับเลือกอาหาร</option>
                                    <?php for($i = 0; $i < $_SESSION['booking']['booking']['pas_num']; $i++){?>
                                        <option value="<?php echo $_SESSION['booking']['passenger'][$i]["firstname"]; ?>"> <?php echo 'คุณ : ' . $_SESSION['booking']['passenger'][$i]["firstname"]; ?> </option>
                                    <?php }?>
						        </select>

                                <ul id="selectedDishesSummary" class="list-disc pl-5"></ul>

                                <div id="totalPriceSummary" class="text-center font-bold mt-4">ราคารวมทั้งหมด: 0 THB</div>

                                <div
                                    class="flex justify-center mt-4 gap-6 sm:items-center py-1 px-1 md:py-1 px-1 lg:py-1 px-1">
                                    <button onclick="removeFood()"
                                            class="bg-red-500 hover:bg-red-700 text-white  py-1 px-7 rounded-xl">
                                            ลบ
                                    </button>
                                </div>

                            </div>
                    </div>

                    <div class="flex flex-wrap justify-center">
                            <!-- food -->
                            <div class="w-full sm:w-1/2 lg:w-1/3 p-4">
                                <div class="border p-4 rounded-md shadow-md bg-white">
                                    <h2 class="text-lg text-center font-bold mb-2">ซี่โครงราดซอส</h2>
                                    <img src="picture/A8.jpg" alt="" class="w-full h-auto object-cover rounded">
                                    <div class="flex justify-between items-center mt-4">

                                        <button id="f1"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-5 rounded-2xl">
                                            +
                                        </button>
                                        <span class="text-lg">399 THB</span>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/2 lg:w-1/3 p-4">
                                <div class="border p-4 rounded-md shadow-md bg-white">
                                    <h2 class="text-lg text-center font-bold mb-2">ข้าวต้มทรงเครื่อง</h2>
                                    <img src="picture/A2.jpg" alt="" class="w-full h-auto object-cover rounded">
                                    <div class="flex justify-between items-center mt-4">
                                        <button id="f2"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-5 rounded-2xl">
                                            +
                                        </button>
                                        <span class="text-lg">299 THB</span>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/2 lg:w-1/3 p-4">
                                <div class="border p-4 rounded-md shadow-md bg-white">
                                    <h2 class="text-lg text-center font-bold mb-2">มัสมั่นเนื้อ</h2>
                                    <img src="picture/A9.png" alt="" class="w-full h-auto object-cover rounded">
                                    <div class="flex justify-between items-center mt-4">
                                        <button id="f3"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-5 rounded-2xl">
                                            +
                                        </button>
                                        <span class="text-lg">499 THB</span>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/2 lg:w-1/3 p-4">
                                <div class="border p-4 rounded-md shadow-md bg-white">
                                    <h2 class="text-lg text-center font-bold mb-2">ขนมครกทรงเครื่อง</h2>
                                    <img src="picture/A4.jpg" alt="" class="w-full h-auto object-cover rounded">
                                    <div class="flex justify-between items-center mt-4">
                                        <button id="f4"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-5 rounded-2xl">
                                            +
                                        </button>
                                        <span class="text-lg">259 THB</span>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/2 lg:w-1/3 p-4">
                                <div class="border p-4 rounded-md shadow-md bg-white">
                                    <h2 class="text-lg text-center font-bold mb-2">ออมเล็ตราดซอส</h2>
                                    <img src="picture/A5.jpg" alt="" class="w-full h-auto object-cover rounded">
                                    <div class="flex justify-between items-center mt-4">
                                        <button id="f5"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-5 rounded-2xl">
                                            +
                                        </button>
                                        <span class="text-lg">299 THB</span>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/2 lg:w-1/3 p-4">
                                <div class="border p-4 rounded-md shadow-md bg-white">
                                    <h2 class="text-lg text-center font-bold mb-2">สเต็กซี่โครงราดซอส</h2>
                                    <img src="picture/A1.jpg" alt="" class="w-full h-auto object-cover rounded">
                                    <div class="flex justify-between items-center mt-4">
                                        <button id="f6"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-5 rounded-2xl">
                                            +
                                        </button>
                                        <span class="text-lg">399 THB</span>
                                    </div>
                                </div>
                            </div>

                    </div>


                </div>
            </div>



            <!-- car rent -->
            <h2 class="text-2xl font-bold mb-6 mt-10 my-10 mx-10">บริการรถเช่า</h2>
            <div class="flex justify-center border p-4 rounded-md shadow-md bg-white">
                <div class="w-full max-w-md">
                    <div class="text-gray-600 mb-2 text-center font-bold">เพิ่มบริการรถเช่า</div>

                    <!-- Pick-up section -->

                    <div class="mb-4 flex justify-between">
                        <div class="w-1/2 pr-2">
                            <label for="pickUpDate" class="block text-gray-700">วันที่ Pick-up</label>
                            <input type="date" id="pickUpDate" name="pickUpDate" class="w-full border rounded p-2">
                        </div>

                        <div class="w-1/2 pl-2">
                            <label for="pickUpTime" class="block text-gray-700">เวลา Pick-up</label>
                            <input type="time" id="pickUpTime" name="pickUpTime" class="w-full border rounded p-2">
                        </div>
                    </div>

                    <!-- Drop-off section -->
                    <div class="mb-4 flex justify-between">
                        <div class="w-1/2 pr-2">
                            <label for="dropOffDate" class="block text-gray-700">วันที่ Drop-off</label>
                            <input type="date" id="dropOffDate" name="dropOffDate" class="w-full border rounded p-2">
                        </div>

                        <div class="w-1/2 pl-2">
                            <label for="dropOffTime" class="block text-gray-700">เวลา Drop-off</label>
                            <input type="time" id="dropOffTime" name="dropOffTime" class="w-full border rounded p-2">
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="flex justify-center mt-4">
                        <button onclick="calculatePrice();"
                            class="bg-white hover:bg-red-500 hover:text-white border text-red-500 border-red-500  py-2 px-9 rounded-xl">
                            คำนวณราคา
                        </button>
                    </div>

                    <!-- Summary section for car rental -->
                    <div id="carRentalSummary" class="flex justify-center mt-4">
                        <div class="max-w-md p-6 bg-white rounded-lg shadow-md bg-white w-full">

                            <h2 class="text-lg font-bold mb-2 text-center">สรุปรายการรถเช่า</h2>

                            <h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution1">กรุณาเลือกวันที่</h2>
                            <h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution2">ให้บริการเช่ารถได้มากสุด 30 วัน</h2>
                            <h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution3">กรุณาเลือกเวลา รับ/ส่ง รถ</h2>
                            <h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution4">วันที่ส่งรถมากกว่าวันที่เดินทางกลับ</h2>
                            <h2 class="text-xl text-center text-red-500 font-semibold mb-4 hidden" id="caution5">วันที่รับรถน้อยกว่าวันที่เดินออกทาง</h2>

                            <ul id="carRentalDishesSummary" class="list-disc pl-5 mb-4"></ul>
                            <div id="carRentalTotalPriceSummary" class="text-center font-bold mb-4">ราคาทั้งหมด:
                                0 บาท
                            </div>
                            <div class="flex justify-center mt-4 gap-6 sm:flex flex-col items-center py-2 px-4 md:flex flex-col py-2 px-4 lg:flex flex-col py-2 px-4">
                                <button onclick="removeCar();"
                                        class="bg-white hover:bg-red-500 hover:text-white border text-red-500 border-red-500  py-2 px-9 rounded-xl">
                                    ลบ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- confirm all -->
            <div class="p-4 rounded-md">
                <div class="flex justify-center mt-4 gap-6 sm:flex flex-col items-center py-2 px-4 md:flex flex-col py-2 px-4 lg:flex flex-col py-2 px-4">
                    <button" id="confirm" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full">
                            ยืนยันการเลือกบริการเสริม
                    </button>
                </div>
            </div>

    </div>

</div>


<script src="static/service.js"></script>
<script>
    function calculatePrice() {
            const pickUpDate = new Date(document.getElementById('pickUpDate').value);
            const pickUp = document.getElementById('pickUpDate').value;
            const dropOffDate = new Date(document.getElementById('dropOffDate').value);
            const dropOff = document.getElementById('dropOffDate').value;
            const pickUpTime = document.getElementById('pickUpTime').value;
            const dropOffTime = document.getElementById('dropOffTime').value;
            const duration = (dropOffDate - pickUpDate) / (1000 * 60 * 60 * 24);

			if(pickUpDate == "Invalid Date" || dropOffDate == "Invalid Date")
            {
                caution1.classList.remove('hidden');
            }
            else if(pickUpTime == "" || dropOffTime == ""){
                caution1.classList.add('hidden');
                caution3.classList.remove('hidden');
            }
            else
            {
                caution1.classList.add('hidden');
                caution3.classList.add('hidden');
                caution4.classList.add('hidden');
                caution5.classList.add('hidden');

                if(duration <= 30){
                        caution2.classList.add('hidden');
                        let pricePerDay = (500 - (duration - 1)*5);
                        if(duration == 0)
                        {
                            removeCar();
                            pricePerDay = 0;
                            return;
                    }


                    const totalPrice = duration * pricePerDay;
                    updateSummary(duration, pricePerDay, totalPrice, pickUp, dropOff, pickUpTime, dropOffTime);
                }
            }
        }
    document.addEventListener("DOMContentLoaded", function () {
                const dropOffInput = document.getElementById('dropOffDate');
                const pickUpInput = document.getElementById('pickUpDate');
                const dropOffDate = new Date(dropOffInput.value);
                const pickUpDate = new Date(pickUpInput.value);
                dropOffInput.addEventListener("change", function () {
                    const dropOffDate = new Date(dropOffInput.value);
                    const pickUpDate = new Date(pickUpInput.value);
                    const duration = (dropOffDate - pickUpDate) / (1000 * 60 * 60 * 24);
                    if (dropOffDate < pickUpDate) {
                        dropOffInput.valueAsDate = pickUpDate;
                    }
                    if(duration > 30)
                    {
                        removeCar();
                        caution2.classList.remove('hidden');
                    }
                    <?php if(isset($_SESSION['booking']['booking']['ret']['date_return'])){?>
                    if(dropOffDate > new Date("<?php echo $_SESSION['booking']['booking']['ret']['date_return'];?>"))
                    {
                        dropOffInput.valueAsDate = new Date("<?php echo $_SESSION['booking']['booking']['ret']['date_return'];?>");
                    }
                    <?php } ?>
                });

                pickUpInput.addEventListener("change", function () {
                    const dropOffDate = new Date(dropOffInput.value);
                    const pickUpDate = new Date(pickUpInput.value);
                    if(pickUpDate < new Date("<?php echo $_SESSION['booking']['booking']['out']['date_out'];?>"))
                    {
                        pickUpInput.valueAsDate = new Date("<?php echo $_SESSION['booking']['booking']['out']['date_out'];?>");
                    }
                    <?php if(isset($_SESSION['booking']['booking']['ret']['date_return'])){?>
                    if(pickUpDate > new Date("<?php echo $_SESSION['booking']['booking']['ret']['date_return'];?>"))
                    {
                        pickUpInput.valueAsDate = new Date("<?php echo $_SESSION['booking']['booking']['ret']['date_return'];?>");
                    }
                    <?php } ?>
                });
            });
</script>
<?php include("includes/footer.php"); ?>
