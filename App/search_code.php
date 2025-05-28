<?php
    header('Cache-Control: no cache');
    session_cache_limiter('private_no_expire');
    session_start();
	$page_title = "ค้นหาเที่ยวบิน";
	include('includes/head.php');
	include("includes/navbar.php");
	include("dbcon.php");
    if (isset($_POST['search'])) {
        $trip_type = $_POST['goes'];
        $pas_num = $_POST['pas_num'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $date_go = $_POST['date'];

        if($trip_type == "go-2")
        {
            $date_return = $_POST['return'];
            $sql_return = "SELECT * FROM flights
                WHERE origin = '$to'
                AND destination = '$from'
                AND '$date_go' <= depart_date <= '$date_return'";
            $run_return = $db->query($sql_return);
            $table_return = [];
            while($row = $run_return->fetchArray(SQLITE3_ASSOC))
            {
                array_push($table_return, $row);
            }
        }


        $sql = "SELECT * FROM flights
                WHERE origin = '$from'
                AND destination = '$to'
                AND depart_date >= '$date_go'";
        $run = $db->query($sql);
        $table_go = [];
        while($row = $run->fetchArray(SQLITE3_ASSOC))
        {
            array_push($table_go, $row);
        }
        if(empty($table_go))
        {
            $_SESSION['status'] = 'ไม่มีเที่ยวบินที่ต้องการ';
            header('location: index.php');
        }
	}
?>
    <div class="flex justify-center mt-5 mb-48">
        <!-- Left Div (3:4) -->
        <div class="flex-4/5">
            <h2 class="text-3xl font-semibold mb-6  mx-10">โปรดเลือกเที่ยวบิน</h2>
            <h4 class="text-xl mb-6  mx-10" id="trip_type" data-trip-type="<?php echo $trip_type;?>">ประเภทเที่ยวบิน :<?php
                if($trip_type == 'go-1')
                {
                    echo ' เที่ยวเดียว';
                }
                else
                {
                    echo ' ไป-กลับ';
                }
                ?>
            </h4>
            <div class="w-full border p-6 mt-10 mx-10 shadow-md bg-white">
                <div class="flex items-start">
                    <div class="border bg-red-500 pr-10 px-6 py-6 rounded-lg">
                        <h2 class="text-3xl font-semibold text-white"><?php echo $from; ?> to <?php echo $to; ?></h2>
                    </div>
                    <div class="text-center flex-1">
                        <h3 class="text-xl font-semibold">ขาไป</h3>
                        <h4 class="text-lg text-gray-600"><?php echo $date_go; ?></h4>
                    </div>
                    <?php if($trip_type == 'go-2'){?>
                    <div class="text-center flex-1">
                        <h3 class="text-xl font-semibold">ขากลับ</h3>
                        <h4 class="text-lg text-gray-600"><?php echo $date_return; ?></h4>
                    </div>
                    <?php } ?>
                    <div class="text-center flex-1">
                        <h3 class="text-xl font-semibold">จำนวนผู้โดยสาร</h3>
                        <h4 class="text-lg text-gray-600" id="pas_num" data-pas-num="<?php echo $pas_num; ?>"><?php echo $pas_num; ?> คน</h4>
                    </div>
                </div>
            </div>


            <h2 class="text-3xl font-semibold mb-6 mt-10 mx-10"><?php echo $from; ?> to <?php echo $to; ?> ขาไป</h2>
            <div id="outbound-flights" class="w-full flex flex-col border p-6 mt-10 mx-10 shadow-md space-y-4 bg-white">

            <?php
                for($i = 0; $i < count($table_go); $i++){
                    ?>
                <div class="w-full flex h-full">
                    <div class="text-center flex-1">
                        <h3 class="text-lg font-semibold"
                        id="outbound-departure-time-<?php echo $i;?>"><?php echo $table_go[$i]['depart_time'];?></h3>
                        <h4 class="text-sm text-red-500"
                        id="outbound-origin-<?php echo $i;?>"><?php echo $table_go[$i]['origin'];?></h4>
                    </div>

                    <div class="text-center flex-1">
                        <h2 id='go_<?php echo $i?>' class="text-xl font-semibold" data-id-go="<?php echo $table_go[$i]['flight_id'];?>">ถึง</h2>
                    </div>

                    <div class="text-center flex-1">
                        <h3 class="text-lg font-semibold"
                        id="outbound-arrival-time-<?php echo $i;?>"><?php echo $table_go[$i]['arrive_time'];?></h3>
                        <h4 class="text-sm text-red-500"
                        id="outbound-dest-<?php echo $i;?>"><?php echo $table_go[$i]['destination'];?></h4>
                    </div>

                    <div class="text-center flex-1">
                        <h3 class="text-lg font-semibold text-red-500">วันที่เดินทาง</h3>
                        <h4 class="text-lg text-red-500"
                        id="outbound-date-<?php echo $i;?>"
                        data-date-out = "<?php echo $table_go[$i]['depart_date']?>"
                        >
                        <?php echo $table_go[$i]['depart_date']?>
                        </h4>
                    </div>

                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-sm price-button hover:bg-red-600"
                        data-price-outbound="<?php echo $table_go[$i]['price'];?>"
                        data-direction="outbound"
                        data-index="<?php echo $i;?>"
                        >
                        <?php echo $table_go[$i]['price'];?> THB
                    </button>
                </div>
            <?php } ?>

            </div>

            <?php if($trip_type == 'go-2'){ ?>
                <h2 class="text-3xl font-semibold mb-6 mt-10 mx-10"><?php echo $to; ?> to <?php echo $from; ?> ขากลับ</h2>

                <div id="return-flights" class="w-full flex flex-col border p-6 mt-10 mx-10 shadow-md bg-white space-y-4">

                <?php
                for($i = 0; $i < count($table_return); $i++){
                    ?>
                    <div class="w-full flex h-full">
                        <div class="text-center flex-1">
                            <h3 class="text-lg font-semibold"
                            id="return-departure-time-<?php echo $i;?>"><?php echo $table_return[$i]['depart_time'];?></h3>
                            <h4 class="text-sm text-red-500"
                            id="return-origin-<?php echo $i;?>"><?php echo $table_return[$i]['origin'];?></h4>
                        </div>

                        <div class="text-center flex-1">
                            <h2 id='back_<?php echo $i?>' class="text-xl font-semibold" data-id-return="<?php echo $table_return[$i]['flight_id'];?>">ถึง</h2>
                        </div>

                        <div class="text-center flex-1">
                            <h3 class="text-lg font-semibold"
                            id="return-arrival-time-<?php echo $i;?>"><?php echo $table_return[$i]['arrive_time'];?></h3>
                            <h4 class="text-sm text-red-500"
                            id="return-dest-<?php echo $i;?>"><?php echo $table_return[$i]['destination'];?></h4>
                        </div>

                        <div class="text-center flex-1">
                            <h3 class="text-lg font-semibold text-red-500">วันที่กลับ</h3>
                            <h4 class="text-lg text-red-500"
                            id="return-date-<?php echo $i;?>"
                            data-date-return="<?php echo $table_return[$i]['depart_date']?>"
                            >
                            <?php echo $table_return[$i]['depart_date']?>
                            </h4>
                        </div>

                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-sm price-button hover:bg-red-600"
                            data-price-return="<?php echo $table_return[$i]['price'];?>"
                            data-direction="return"
                            data-index="<?php echo $i;?>"
                            >
                            <?php echo $table_return[$i]['price'];?> THB
                        </button>
                    </div>

                    <?php } ?>


                </div>
            <?php } ?>


        </div>

        <!-- Right Div (1:4) -->
        <div class="w-1/4 h-1/4 pl-10 flex justify-center">
            <div class="border p-6 shadow-md bg-white mt-10 mx-10 w-full">
                <h2 class="text-xl font-semibold mb-4">สรุปการจอง</h2>
                <h2 class="text-xl text-red-500 font-semibold mb-4 hidden" id="caution">กรุณาเลือกเที่ยวบิน</h2>
                <h2 class="text-xl text-red-500 font-semibold mb-4 hidden" id="caution1">วันเดินทางกลับควรมากกว่าหรือเท่ากับวันเดินทางออก</h2>
                <h2 class="text-xl text-red-500 font-semibold mb-4 hidden" id="caution2">เวลาเดินทางกลับควรมากกว่าวันเดินทางออก</h2>
                    <div id="summary" class="mb-4">
                        <div class="text-lg" id="go" name="go"></div>
                        <?php if($trip_type == 'go-2'){ ?>
                            <div class="text-lg" id="back" name="back" ></div>
                        <?php } ?>
                        <div class="text-lg font-semibold" id="total-price"></div>
                    </div>
                    <button type="button" id="confirm" name="confirm" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 ">ยืนยันการเลือกเที่ยวบิน</button></button>
            </div>
        </div>

    </div>


<script src="static/search.js"></script>
<?php include('includes/footer.php')?>
