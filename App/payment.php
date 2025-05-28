<?php
	session_start();
	$page_title = "ชำระเงิน";
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
        $seat_data = json_decode($_GET['data']);
        $_SESSION['booking']['seat'] = $seat_data;
    }

    if(isset($_GET['method']))
    {
        $method = $_GET['method'];
        $_SESSION['booking']['method'] = $method;
    }
	$booking = $_SESSION['booking']['booking'];
	$passenger = $_SESSION['booking']['passenger'];
	$service = $_SESSION['booking']['service'];
	$seat = $_SESSION['booking']['seat'];
	$sum = 0;
	if($service->insurance != [])
	{
		$insurance = $service->insurance[1];
	}
	else{
		$insurance = 0;
	}

	$sum_food = 0;
	if($service->car_rent != [])
	{
		$sum_car = $service->car_rent->totalPrice;
	}
	else{
		$sum_car = 0;
	}

	$lug_sum = 0;
	$com_pass = [];
	for ($i = 0; $i < $booking['pas_num']; $i++) {
		$temp = [];
		$temp['out_id'] = $booking['out']['out_id'];
		if($booking['trip_type'] == 'go-2')
		{
			$temp['ret_id'] = $booking['ret']['ret_id'];
			$temp['backLug'] = $seat->luggage[$i]->backLug;
			$temp['seat_back'] = $seat->seats[$i + $booking['pas_num']]->seat_back[1];
			$lug_sum += ($seat->luggage[$i]->goLug + $seat->luggage[$i]->backLug);
		}
		else
		{
			$lug_sum += ($seat->luggage[$i]->goLug);
		}
		$temp['prefix'] = $passenger[$i]['prefix'];
		$temp['firstname'] = $passenger[$i]['firstname'];
		$temp['lastname'] = $passenger[$i]['lastname'];
		$temp['fisrtname_eng'] = $passenger[$i]['firstname_eng'];
		$temp['lastname_eng'] = $passenger[$i]['lastname_eng'];
		$temp['email'] = $passenger[$i]['email'];
		$temp['phone'] = $passenger[$i]['phone'];
		$temp['DOB'] = $passenger[$i]['DOB'];
		$temp['nationality'] = $passenger[$i]['nationality'];
		if($service->insurance != [])
		{
			$temp['insurance'] = $service->insurance[0];
		}
		else
		{
			$temp['insurance'] = '';
		}

		$temp_food = [];
		foreach($service->food[0] as $food){
			if($food[2] == $passenger[$i]['firstname'])
			{
				array_push($temp_food, $food[0]);
				$sum_food += $food[1];
			}
		}
		$temp['food'] = $temp_food;
		if($service->car_rent != []){
			$temp['pickUpDate'] = $service->car_rent->pickUpDate;
			$temp['pickUpTime'] = $service->car_rent->pickUpTime;
			$temp['dropOffDate'] = $service->car_rent->dropOffDate;
			$temp['dropOffTime'] = $service->car_rent->dropOffTime;
		}

		$temp['goLug'] = $seat->luggage[$i]->goLug;
		$temp['seat_go'] = $seat->seats[$i]->seat_go[1];

		array_push($com_pass, $temp);
        $_SESSION['finish'] = $com_pass;
	}

	if($booking['trip_type'] == 'go-2')
	{
		$sum = $booking['out']['out_price']*$booking['pas_num']
		+ $booking['ret']['ret_price']*$booking['pas_num']
		+ $insurance + $sum_food + $sum_car + $lug_sum*30;
	}
	else
	{
		$sum = $booking['out']['out_price']*$booking['pas_num']
		+ $insurance + $sum_food + $sum_car + $lug_sum*30;
	}

?>

<div class="container mx-auto p-8">
        <h1 class="text-3xl font-semibold mb-6 text-left text-color-primary">เที่ยวบิน</h1>

        <!-- ใส่การ์ดรอบข้อมูลขาไปและขากลับ -->
        <div class="bg-white rounded-lg shadow-lg p-4 space-y-4">
            <!-- ข้อมูลขาไป -->
            <div class=" justify-between items-center sm:flex">
                <div class="flex-1 text-center mx-auto">
                    <h3 class="text-orange-500 text-xl font-semibold mb-4"><?php echo $booking['out']['out_origin'];?> to <?php echo $booking['out']['out_dest'];?></h3>
                    <p class="font-sarabun">ขาไป <?php echo $booking['out']['date_out'];?><br>เวลา <?php echo $booking['out']['out_dep'];?> ถึง <?php echo $booking['out']['out_arv'];?></p>
                    <br>
					<?php if($booking['trip_type'] == 'go-2'){?>
                    	<h3 class="text-orange-500 text-xl font-semibold mb-4"><?php echo $booking['ret']['ret_origin'];?> to <?php echo $booking['ret']['ret_dest'];?></h3>
                    	<p class="font-sarabun">ขากลับ <?php echo $booking['ret']['date_return'];?> <br>เวลา <?php echo $booking['ret']['ret_dep'];?> ถึง <?php echo $booking['ret']['ret_arv'];?></p>
					<?php }?>
				</div>
                <div class="flex-1">
				<?php if($booking['trip_type'] == 'go-2'){?>
                    <div class="text-center flex justify-between mb-4 max-sm:mt-5">
                        <div class="font-semibold">ราคาตั๋วไป-กลับ</div>
                        <div class="text-right"><?php echo $booking['out']['out_price'] + $booking['ret']['ret_price'];?> บาท</div>
                    </div>
				<?php }
				else{?>
					<div class="text-center flex justify-between mb-4 max-sm:mt-5">
                        <div class="font-semibold">ราคาตั๋วขาไป</div>
                        <div class="text-right"><?php echo $booking['out']['out_price'];?>  บาท</div>
                    </div>
				<?php }?>

                    <div class="text-center flex justify-between mb-4">
                        <div class="font-semibold">จำนวนผู้โดยสาร</div>
                        <div class="text-right "><?php echo $booking['pas_num'];?> คน</div>
                    </div>
                    <div class="text-center flex justify-between mb-4">
                        <div class="font-semibold">เพิ่มน้ำหนักสัมภาระ</div>
                        <div class="text-right "><?php echo $lug_sum;?> กิโลกรัม</div>
                    </div>
                    <div class="text-center flex justify-between mb-4">
                        <div class="font-semibold ">เพิ่มประกันการเดินทาง</div>
                        <div class="text-right "><?php echo $insurance;?> บาท</div>
                    </div>
                    <div class="text-center flex justify-between mb-4">
                        <div class="font-semibold ">เพิ่มอาหารบนเครื่องบิน</div>
                        <div class="text-right "><?php echo $sum_food;?> บาท</div>
                    </div>
                    <div class="text-center flex justify-between mb-4">
                        <div class="font-semibold ">เพิ่มรถเช่า</div>
                        <div class="text-right "><?php echo $sum_car;?> บาท</div>
                    </div>
                    <div class="text-center flex justify-between">
                        <div class="font-semibold ">รวมทั้งหมด</div>
                        <div class="text-right "><?php echo $sum;?> บาท</div>
                    </div>
                    <?php if(isset($_SESSION['booking']['method'])){?>
                    <div class="text-center flex justify-between mt-4">
                        <div class="font-semibold ">วิธีการชำระเงิน</div>
                        <div class="text-right "><?php echo $_SESSION['booking']['method'];?></div>
                    </div>
                    <?php }?>
                    <h2 class="text-xl text-center text-red-500 font-semibold m-4 hidden" id="caution">กรุณาเลือกวิธีการชำระเงิน</h2>
                </div>
            </div>
        </div>
        <!-- Bank---------------------------------------------------------------- -->
        <section class="max-w-[900px] mx-auto px-8 pt-14">
            <h1 class="text-2xl  font-bold text-gray-700 mb-4">
                ช่องทางการชำระเงิน</h1>
            <!-- Direct debit Payment -->
            <h2 class="pb-2">Credit/Debit</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Mastercard -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-4 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <!-- Change size image by padding -->
                                <a href="payment.php?method=Mastercard">
                                <img class="h-full max-w-auto mx-auto p-2"
                                    src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                        opacity-70 font-medium">Mastercard</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- Visa -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
					gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
						peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Visa">
                                <img class="h-24 mx-auto p-7 pb-8"
                                    src="data:image/png;base64,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">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
            		opacity-70 font-medium">Visa</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- Union Pay -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                		gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
              		peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Union pay">
                                <img class="h-20 mx-auto p-2"
                                    src="https://logowik.com/content/uploads/images/union-pay.jpg">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                            opacity-70 font-medium">Union Pay</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!--kasikorn bank -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  	peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Kasikorn Bank">
                                <img class="h-24 mx-auto "
                                    src="https://cdn2.downdetector.com/static/uploads/logo/kasikornbank-logo.png">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                                opacity-70 font-medium">Kasikorn Bank</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- krungthai Pay -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                		gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
              			peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Krunthai Pay">
                                <img class="h-20 mx-auto p-4 pt-6"
                                    src="data:image/png;base64,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">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                            opacity-70 font-medium">KringThai Bank</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- SCB Bank -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  	peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=SCB Bank">
                                <img class="h-24 mx-auto p-5 pb-6"
                                    src="data:image/png;base64,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">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                                opacity-70 font-medium">Siam Commercial Bank</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- Krungsri Bank -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Krungsri Bank">
                                <img class="h-24 mx-auto p-6 pt-4 pb-7"
                                src="data:image/png;base64,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">
                                </a>
                            </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                                opacity-70 font-medium">Krungsri Bank</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- Bankok Bank -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=BangKok Bank">
                                <img class="h-24 mx-auto p-4 "
                                src="data:image/png;base64,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">
                                </a>
                            </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                                opacity-70 font-medium">Bangkok Bank</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- TMB Bank -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=TMB Bank">
                                    <img class="h-24 mx-auto p-4 pb-6"
                                    src="https://assets.brandinside.asia/uploads/2021/05/1620365513924..jpg">
                                </a>
                            </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                                opacity-70 font-medium">Thanachart Bank</p>
                            </div>
                        </div>
                    </div>
                </label>
        </section>

        <!-- E-wallet Payment andE-wallet only thai -->
        <section class="max-w-[900px] mx-auto px-8 pt-8 ">
            <h2 class="pb-2 ">E-Wallet</h2>
            <!-- Alipay -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-4 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Alipay">
                                <img class="h-full max-w-auto mx-auto p-3 pt-6"
                                    src="data:image/png;base64,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">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                        opacity-70 font-medium">Alipay</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- We chat Pay -->
            <label for="payment" class="relative w-full cursor-pointer">
                      <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                    peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=WeChat Pay">
                                <img class="h-24 mx-auto p-6 pb-7 "
                                    src="https://upload.wikimedia.org/wikipedia/commons/7/7a/WeChat_Pay.png">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                            opacity-70 font-medium">WeChat Pay</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- rabbit LINE Pay -->
            <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                    peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Rabbit Line Pay">
                                <img class="h-24 mx-auto p-3 pb-6"
                                    src="data:image/png;base64,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">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                            opacity-70 font-medium">Rabbit Line Pay</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- TRue money wallet -->
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                      gap-2 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                    peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=True Money Wallet">
                                <img class="h-24 mx-auto p-4 pb-7"
                                    src="https://upload.wikimedia.org/wikipedia/commons/d/da/Truemoney-wallet_thai.png">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                            opacity-70 font-medium">True Money wallet</p>
                            </div>
                        </div>
                    </div>
                </label>
        </section>

        <!-- QR Payment -->
        <section class="max-w-[900px] mx-auto px-8 pt-8">
            <h2 class="pb-2">Thai QR Payment</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-4 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Prompy Pay">
                                <img class="h-full max-w-auto mx-auto p-2 pt-4 "
                                    src="data:image/png;base64,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">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                        opacity-70 font-medium">Prompt Pay</p>
                            </div>
                        </div>
                    </div>
                </label>
        </section>
        <!--counter service -->
        <section class="max-w-[900px] mx-auto px-8 pt-8">
            <h2 class="p-2 ">Counter Service</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label for="payment" class="relative w-full cursor-pointer">
                    <div class="payment-content border-3 hover:border-blue-500 items-center relative
                    gap-4 h-28 w-full bg-white border-2 border-gray-200 rounded-md transition
                  peer-checked:border-blue-500 peer-checked:shadow-lg peer-checked:-translate-y-1 ">
                        <div class="h-24 w-full text-center ">
                            <div class="h-4/5 text-center">
                                <a href="payment.php?method=Counter Service 7-11">
                                <img class="h-full max-w-auto mx-auto"
                                    src="https://www.sosthailand.or.th/getmedia/1094cc58-3ae4-49df-a9dd-5cb345847d50/Counter-Service-7-Eleven-logo.png?width=425">
                                </a>
                                </div>
                            <div class="h-1/5">
                                <p class="payment-text text-center text-sm
                                opacity-70 font-medium">Counter Service 7-11</p>
                            </div>
                        </div>
                    </div>
                </label>
        </section>

		<div>
            <button id="confirm" class="my-6 mx-auto rounded-lg bg-red-500 px-6 py-4 text-xl text-white hover:bg-red-700
            focus:outline-none active:bg-red-800 block">ดำเนินการต่อ</button>
        </div>
	</div>


	<script></script>


<script>
	$(document).ready(function() {
			$('a').click(function() {
				$(this).css('border-color', 'blue');
			});
			$('#confirm').click(function() {
                <?php if(isset($_SESSION['booking']['seat']) and isset($_SESSION['booking']['method'])){?>
				    var data = JSON.stringify({amount: <?php echo $sum;?>, method: "<?php echo $_SESSION['booking']['method'];?>"});
				    window.location.href = "ticket.php?data=" + data;
                <?php }else {?>
                    caution.classList.remove('hidden');
                <?php }?>

            });
	});
</script>
<?php include("includes/footer.php")?>
