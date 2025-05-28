<?php
	session_start();
	$page_title = "กรอกข้อมูลผู้ใช้";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");

if (isset($_GET['out_origin'])) {
	$out_origin = $_GET['out_origin'];
	$out_dest = $_GET['out_dest'];
	$out_price = $_GET['out_price'];
	$out_dep = $_GET['out_dep'];
	$out_arv = $_GET['out_arv'];
	$date_out = $_GET['date_out'];
	$out_id = $_GET['out_id'];

	$pas_num = $_GET['pas_num'];
	$trip_type = $_GET['trip_type'];
	$date_out = $_GET['date_out'];

	if ($trip_type == 'go-2') {
		$date_return = $_GET['date_return'];
		$ret_origin = $_GET['ret_origin'];
		$ret_dest = $_GET['ret_dest'];
		$ret_price = $_GET['ret_price'];
		$ret_dep = $_GET['ret_dep'];
		$ret_arv = $_GET['ret_arv'];
		$ret_id = $_GET['ret_id'];

		$_SESSION['booking'] = array( "booking" => [
			"out" => ["out_origin" => $out_origin,
			"out_dest" => $out_dest,
			"out_price" => $out_price,
			"out_dep" => $out_dep,
			"out_arv" => $out_arv,
			"out_id" => $out_id,
			"date_out" => $date_out],
			"ret" => ["ret_origin" => $ret_origin,
			"ret_dest" => $ret_dest,
			"ret_price" => $ret_price,
			"ret_dep" => $ret_dep,
			"ret_arv" => $ret_arv,
			"ret_id" => $ret_id,
			"date_return" => $date_return],
			"pas_num" => $pas_num,
			"trip_type" => $trip_type]
		);
	} else {
		$_SESSION['booking'] = array("booking" => [
			"out" => ["out_origin" => $out_origin,
			"out_dest" => $out_dest,
			"out_price" => $out_price,
			"out_dep" => $out_dep,
			"out_arv" => $out_arv,
			"out_id" => $out_id,
			"date_out" => $date_out],
			"pas_num" => $pas_num,
			"trip_type" => $trip_type]
		);
	}
}
else
    {
        header('location: index.php');
    }

?>
<link rel="stylesheet" href="static/error.css">




	<div class="flex justify-center mt-10 sm:flex flex-col items-center my-10 mx-10">
        <div class="w-2/4">
            <div class="border p-6 shadow-md bg-white">
                <h2 class="text-2xl font-bold mb-2">ขาไป : <?php echo $out_origin;?> to <?php echo $out_dest;?></h2>
                <div class="text-lg text-gray-800 mb-2">รายละเอียดเที่ยวบิน</div>
                <div class="text-gray-600 mb-2">เวลาที่ออกเดินทาง : <?php echo $out_dep;?></div>
                <div class="text-gray-600 mb-2">เวลาที่ถึง : <?php echo $out_arv;?></div>
                <div class="text-gray-600 mb-2">วันที่ออกเดินทาง : <?php echo $date_out;?></div>
                <div class="text-red-500 font-bold underline"><?php echo $out_price;?> บาท</div>
            </div>
        </div>
		<?php if($trip_type == 'go-2') {?>
			<div class="w-2/4">
				<div class="border p-6 my-10 shadow-md bg-white">
					<h2 class="text-2xl font-bold mb-2">ขากลับ : <?php echo $ret_origin;?> to <?php echo $ret_dest;?></h2>
					<div class="text-lg text-gray-800 mb-2">รายละเอียดเที่ยวบิน</div>
                	<div class="text-gray-600 mb-2">เวลาที่เดินทางกลับ : <?php echo $ret_dep;?></div>
                	<div class="text-gray-600 mb-2">เวลาที่ถึง : <?php echo $ret_arv;?></div>
                	<div class="text-gray-600 mb-2">วันที่เดินทางกลับ : <?php echo $date_return;?></div>
					<div class="text-red-500 font-bold underline"><?php echo $ret_price;?> บาท</div>
				</div>
			</div>
		<?php }?>
    </div>

        <form id="passenger_form" action="service.php" method="POST" class="flex flex-col gap-4" novalidate>
		<div class="h-96 overflow-x-hidden overflow-y-scroll w-auto">
		<?php for($i = 1; $i < $pas_num+1; $i++) { ?>
			<div class="mx-auto mt-10 mb-5 border p-6 shadow-md bg-white w-10/12  flex flex-col">
				<h2 class="text-2xl font-semibold m-6 text-center">กรุณากรอกข้อมูลผู้โดยสารคนที่ <?php echo $i;?></h2>
				<div class="mb-4">
					<label for="prefix_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">คำนำหน้าชื่อ</label>
					<select id="prefix_<?php echo $i; ?>" name="prefix_<?php echo $i; ?>" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white bg-white bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<option value="" selected disabled>Please select</option>
						<option value="Mr.">Mr.</option>
						<option value="Mrs.">Mrs.</option>
						<option value="Miss">Miss</option>
						<option value="Master">Master</option>
						<option value="Ms.">Ms.</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div>
					<label for="firstname_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">ชื่อจริง</label>
					<div class="mt-2">
						<input id="firstname_<?php echo $i; ?>" name="firstname_<?php echo $i; ?>" type="text" autocomplete="given-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<p id="firstname-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
					</div>
				</div>

				<div>
					<label for="lastname_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">นามสกุล</label>
					<div class="mt-2">
						<input id="lastname_<?php echo $i; ?>" name="lastname_<?php echo $i; ?>" type="text" autocomplete="family-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<p id="lastname-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
					</div>
				</div>

				<div>
					<label for="firstname_eng_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">ชื่อจริงภาษาอังกฤษ</label>
					<div class="mt-2">
						<input id="firstname_eng_<?php echo $i; ?>" name="firstname_eng_<?php echo $i; ?>" type="text" autocomplete="given-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<p id="firstname_eng-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
					</div>
				</div>

				<div>
					<label for="lastname_eng_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">นามสกุลภาษาอังกฤษ</label>
					<div class="mt-2">
						<input id="lastname_eng_<?php echo $i; ?>" name="lastname_eng_<?php echo $i; ?>" type="text" autocomplete="family-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<p id="lastname_eng-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
					</div>
				</div>

				<div>
					<label for="email_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">อีเมล</label>
					<div class="mt-2">
						<input id="email_<?php echo $i; ?>" name="email_<?php echo $i; ?>" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<p id="email-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
					</div>
				</div>

				<div>
					<label for="phone_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">โทรศัพท์</label>
					<div class="mt-2">
						<input id="phone_<?php echo $i; ?>" name="phone_<?php echo $i; ?>" type="tel" autocomplete="tel" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<p id="phone-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
					</div>
				</div>

				<div>
					<label for="dob_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">วันเกิด</label>
					<div class="mt-2">
						<input type="date" id="DOB_<?php echo $i; ?>" name="DOB_<?php echo $i; ?>" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
							<p id="DOB-error_<?php echo $i; ?>" class="text-red-600 text-xs mt-1"></p>
						</div>
				</div>

				<div class="mb-4">
					<label for="nationality_<?php echo $i; ?>" class="block text-md font-medium leading-6 text-gray-900">สัญชาติ</label>
					<select id="nationality_<?php echo $i; ?>" name="nationality_<?php echo $i; ?>" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
						<option value="" disabled selected>โปรดเลือกสัญชาติ</option>
						<option value="thailand">ไทย</option>
						<option value="usa">สหรัฐอเมริกา</option>
						<option value="japan">ญี่ปุ่น</option>
						<option value="afghanistan">อัฟกานิสถาน</option>
						<option value="albania">แอลเบเนีย</option>
						<option value="algeria">แอลจีเรีย</option>
						<option value="andorra">อันดอร์รา</option>
						<option value="angola">แองโกลา</option>
						<option value="argentina">อาร์เจนตินา</option>
						<option value="armenia">อาร์เมเนีย</option>
						<option value="australia">ออสเตรเลีย</option>
						<option value="austria">ออสเตรีย</option>
						<option value="azerbaijan">อาเซอร์ไบจาน</option>
						<option value="bahamas">บาฮามาส</option>
						<option value="bahrain">บาห์เรน</option>
						<option value="bangladesh">บังกลาเทศ</option>
						<option value="barbados">บาร์เบโดส</option>
						<option value="belarus">เบลารุส</option>
						<option value="belgium">เบลเยียม</option>
						<option value="belize">เบลีซ</option>
						<option value="benin">เบนิน</option>
						<option value="bhutan">ภูฏาน</option>
						<option value="bolivia">โบลิเวีย</option>
						<option value="bosnia_and_herzegovina">บอสเนียและเฮอร์เซโกวีนา</option>
						<option value="botswana">บอตสวานา</option>
						<option value="brazil">บราซิล</option>
						<option value="brunei">บรูไน</option>
						<option value="bulgaria">บัลแกเรีย</option>
						<option value="burkina_faso">บูร์กินา ฟาโซ</option>
						<option value="burundi">บุรุนดี</option>
						<option value="cambodia">กัมพูชา</option>
						<option value="cameroon">แคเมอรูน</option>
						<option value="canada">แคนาดา</option>
						<option value="cape_verde">เคปเวิร์ด</option>
						<option value="central_african_republic">สาธารณรัฐแอฟริกากลาง</option>
						<option value="chad">ชาด</option>
						<option value="chile">ชิลี</option>
						<option value="china">จีน</option>
						<option value="colombia">โคลอมเบีย</option>
						<option value="comoros">คอโมโรส</option>
						<option value="congo">คองโก - บราซซาวิล</option>
						<option value="costa_rica">คอสตาริกา</option>
						<option value="croatia">โครเอเชีย</option>
						<option value="cuba">คิวบา</option>
						<option value="cyprus">ไซปรัส</option>
						<option value="czech_republic">สาธารณรัฐเช็ก</option>
						<option value="dr_congo">คองโก - กินชาซาฝิล</option>
						<option value="denmark">เดนมาร์ก</option>
						<option value="djibouti">จิบูตี</option>
						<option value="dominica">โดมินิกา</option>
						<option value="dominican_republic">สาธารณรัฐโดมินิกัน</option>
						<option value="east_timor">ติมอร์ ตะวันออก</option>
						<option value="ecuador">เอกวาดอร์</option>
						<option value="egypt">อียิปต์</option>
						<option value="el_salvador">เอลซัลวาดอร์</option>
						<option value="equatorial_guinea">อิเควทอเรียลกินี</option>
						<option value="eritrea">เอริเทรีย</option>
						<option value="estonia">เอสโตเนีย</option>
						<option value="ethiopia">เอธิโอเปีย</option>
						<option value="fiji">ฟีจี</option>
						<option value="finland">ฟินแลนด์</option>
						<option value="france">ฝรั่งเศส</option>
						<option value="gabon">กาบอง</option>
						<option value="gambia">แกมเบีย</option>
						<option value="georgia">จอร์เจีย</option>
						<option value="germany">เยอรมนี</option>
						<option value="ghana">กานา</option>
						<option value="greece">กรีซ</option>
						<option value="grenada">เกรนาดา</option>
						<option value="guatemala">กัวเตมาลา</option>
						<option value="guinea">กินี</option>
						<option value="guinea_bissau">กินี-บิสเซา</option>
						<option value="guyana">กายอานา</option>
						<option value="haiti">เฮติ</option>
						<option value="honduras">ฮอนดูรัส</option>
						<option value="hungary">ฮังการี</option>
						<option value="iceland">ไอซ์แลนด์</option>
						<option value="india">อินเดีย</option>
						<option value="indonesia">อินโดนีเซีย</option>
						<option value="iran">อิหร่าน</option>
						<option value="iraq">อิรัก</option>
						<option value="ireland">ไอร์แลนด์</option>
						<option value="israel">อิสราเอล</option>
						<option value="italy">อิตาลี</option>
						<option value="ivory_coast">ไอวอรี่โคสต์</option>
						<option value="jamaica">จาเมกา</option>
						<option value="jordan">จอร์แดน</option>
						<option value="kazakhstan">คาซัคสถาน</option>
						<option value="kenya">เคนยา</option>
						<option value="kiribati">คิริบาส</option>
						<option value="kosovo">โคโซโว</option>
						<option value="kuwait">คูเวต</option>
						<option value="kyrgyzstan">คีร์กีซสถาน</option>
						<option value="laos">ลาว</option>
						<option value="latvia">ลัตเวีย</option>
						<option value="lebanon">เลบานอน</option>
						<option value="lesotho">เลโซโท</option>
						<option value="liberia">ลิเบรีย</option>
						<option value="libya">ลิเบีย</option>
						<option value="liechtenstein">ลิกเตนสไตน์</option>
						<option value="lithuania">ลิทัวเนีย</option>
						<option value="luxembourg">ลักเซมเบิร์ก</option>
						<option value="macedonia">มาซิโดเนีย</option>
						<option value="madagascar">มาดากัสการ์</option>
						<option value="malawi">มาลาวี</option>
						<option value="malaysia">มาเลเซีย</option>
						<option value="maldives">มัลดีฟส์</option>
						<option value="mali">มาลี</option>
						<option value="malta">มอลตา</option>
						<option value="marshall_islands">หมู่เกาะมาร์แชลล์</option>
						<option value="mauritania">โมริเตเนีย</option>
						<option value="mauritius">มอริเชียส</option>
						<option value="mexico">เม็กซิโก</option>
						<option value="micronesia">ไมโครนีเซีย</option>
						<option value="moldova">มอลโดวา</option>
						<option value="monaco">โมนาโก</option>
						<option value="mongolia">มองโกเลีย</option>
						<option value="montenegro">มอนเตเนโกร</option>
						<option value="morocco">โมร็อกโก</option>
						<option value="mozambique">โมซัมบิก</option>
						<option value="myanmar">เมียนมาร์</option>
						<option value="namibia">นามิเบีย</option>
						<option value="nauru">นาอูรู</option>
						<option value="nepal">เนปาล</option>
						<option value="netherlands">เนเธอร์แลนด์</option>
						<option value="new_zealand">นิวซีแลนด์</option>
						<option value="nicaragua">นิการากัว</option>
						<option value="niger">ไนเจอร์</option>
						<option value="nigeria">ไนจีเรีย</option>
						<option value="north_korea">เกาหลีเหนือ</option>
						<option value="norway">นอร์เวย์</option>
						<option value="oman">โอมาน</option>
						<option value="pakistan">ปากีสถาน</option>
						<option value="palau">ปาเลา</option>
						<option value="panama">ปานามา</option>
						<option value="papua_new_guinea">ปาปัวนิวกินี</option>
						<option value="paraguay">ปารากวัย</option>
						<option value="peru">เปรู</option>
						<option value="philippines">ฟิลิปปินส์</option>
						<option value="poland">โปแลนด์</option>
						<option value="portugal">โปรตุเกส</option>
						<option value="qatar">กาตาร์</option>
						<option value="romania">โรมาเนีย</option>
						<option value="russia">รัสเซีย</option>
						<option value="rwanda">รวันดา</option>
						<option value="saint_kitts_and_nevis">เซนต์คิตส์และเนวิส</option>
						<option value="saint_lucia">เซนต์ลูเซีย</option>
						<option value="saint_vincent_and_the_grenadines">เซนต์วินเซนต์และเกรนาดีนส์</option>
						<option value="samoa">ซามัว</option>
						<option value="san_marino">ซานมาริโน</option>
						<option value="sao_tome_and_principe">เซาตูเมและปรินซิปี</option>
						<option value="saudi_arabia">ซาอุดีอาระเบีย</option>
						<option value="senegal">เซเนกัล</option>
						<option value="serbia">เซอร์เบีย</option>
						<option value="seychelles">เซเชลส์</option>
						<option value="sierra_leone">เซียร์ราลีโอน</option>
						<option value="singapore">สิงคโปร์</option>
						<option value="slovakia">สโลวาเกีย</option>
						<option value="slovenia">สโลวีเนีย</option>
						<option value="solomon_islands">หมู่เกาะโซโลมอน</option>
						<option value="somalia">โซมาเลีย</option>
						<option value="south_africa">แอฟริกาใต้</option>
						<option value="south_korea">เกาหลีใต้</option>
						<option value="south_sudan">ซูดานใต้</option>
						<option value="spain">สเปน</option>
						<option value="sri_lanka">ศรีลังกา</option>
						<option value="state_of_palestine">ปาเลสไตน์</option>
						<option value="sudan">ซูดาน</option>
						<option value="suriname">ซูรินาเม</option>
						<option value="swaziland">สวาซิแลนด์</option>
						<option value="sweden">สวีเดน</option>
						<option value="switzerland">สวิตเซอร์แลนด์</option>
						<option value="syria">ซีเรีย</option>
						<option value="taiwan">ไต้หวัน</option>
						<option value="tajikistan">ทาจิกิสถาน</option>
						<option value="tanzania">แทนซาเนีย</option>
						<option value="togo">โตโก</option>
						<option value="tonga">ตองกา</option>
						<option value="trinidad_and_tobago">ตรินิแดดและโตเบโก</option>
						<option value="tunisia">ตูนิเซีย</option>
						<option value="turkey">ตุรกี</option>
						<option value="turkmenistan">เติร์กเมนิสถาน</option>
						<option value="tuvalu">ตูวาลู</option>
						<option value="uganda">ยูกันดา</option>
						<option value="ukraine">ยูเครน</option>
						<option value="united_arab_emirates">สหรัฐอาหรับเอมิเรตส์</option>
						<option value="united_kingdom">สหราชอาณาจักร</option>
						<option value="uruguay">อุรุกวัย</option>
						<option value="uzbekistan">อุซเบกิสถาน</option>
						<option value="vanuatu">วานูอาตู</option>
						<option value="vatican_city">นครวาติกัน</option>
						<option value="venezuela">เวนซุเอลา</option>
						<option value="vietnam">เวียดนาม</option>
						<option value="yemen">เยเมน</option>
						<option value="zambia">แซมเบีย</option>
						<option value="zimbabwe">ซิมบับเว</option>
					</select>
				</div>
			</div>
			<?php } ?>
			</div>
			<div class="mx-auto my-10 p-6 w-2/4 flex flex-col">
				<button type="submit" name="confirm" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">บันทึก</button>
			</div>
		</form>



		<script src="static/passenger.js"></script>

		<script>

			for (let i = 1; i < <?php echo $pas_num+1; ?>; i++) {
				document.getElementById(`firstname_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`lastname_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`firstname_eng_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`lastname_eng_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`email_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`phone_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`DOB_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`prefix_${i}`).addEventListener('input', () => validateForm(i));
				document.getElementById(`nationality_${i}`).addEventListener('input', () => validateForm(i));
			}

			$(document).ready(function() {
				$('#passenger_form').submit(function(event) {

					// Check if any required fields are empty
					var formValid = true;
					$(this).find('input[required]').each(function() {
						if ($.trim($(this).val()) === '') {
							formValid = false;
							$(this).addClass('error');
						}
					});

					$(this).find('select[required]').each(function() {
						if ($(this).val() === null || $(this).val() === '') {
						formValid = false;
						$(this).addClass('error'); // You can style the empty selects as needed
						}
					});


					if (!formValid) {
						event.preventDefault();
					}
					else
					{
						// Serialize form data
						var formData = $(this).serialize();

						// Send data to the server using AJAX
						$.ajax({
							type: 'POST',
							url: $(this).attr('action'),
							data: formData,
							error: function(jqXHR, textStatus, errorThrown) {
								console.log('AJAX Error:', textStatus, errorThrown);
							}
						});
					}

				});
			});

		</script>


<?php include('includes/footer.php')?>
