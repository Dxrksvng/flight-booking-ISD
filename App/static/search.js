function extractPrice(text) {
    // Use a regular expression to find a number with optional decimal point
    const regex = /(\d+(\.\d{1,2})?)\s*THB/i;
    const match = text.match(regex);

    if (match) {
        // Extracted price is in match[1]
        return parseFloat(match[1]);
    } else {
        // Return 0 if no price is found
        return 0;
    }
}

var out_origin = '';
var out_dest = '';
var out_price = '';
var out_dep = '';
var out_arv = '';
var ret_origin = '';
var ret_dest = '';
var ret_price = '';
var ret_dep = '';
var ret_arv = '';

var date_out_out = '';
var date_return_out = '';
var out_id = '';
var ret_id = '';


$(document).ready(function () {
    var pas_num = parseFloat($('#pas_num').data('pas-num'));
    var trip_type = $('#trip_type').data('trip-type');



    $('.price-button').click(function () {

        var direction = $(this).data('direction');
        var index = $(this).data('index');
        var origin = $('#' + direction + '-origin-' + index).text();
        var dest = $('#' + direction + '-dest-' + index).text();
        var departureTime = $('#' + direction + '-departure-time-' + index).text();
        var arriveTime = $('#' + direction + '-arrival-time-' + index).text();
        var newSummary = '';

        if (direction === 'outbound') {
            var price_outbound = parseFloat($(this).data('price-outbound'));
            var date_out = $('#outbound-date-' + index).data('date-out');
            date_out_out = date_out;
            var go_id = $("#go_" + index).data('id-go');
            out_id = go_id;
            newSummary = 'ขาไป: ' + origin + ' ถึง ' + dest
            + '<br>&nbsp;&nbsp;ราคา : ' + price_outbound + ' THB<br>&nbsp;&nbsp;เวลา : '
            + departureTime + ' ถึง ' + arriveTime
            + '<br>&nbsp;&nbsp;วันที่ออกเดินทาง : ' + date_out;
            out_origin = origin;
            out_dest = dest;
            out_price = price_outbound;
            out_dep = departureTime;
            out_arv = arriveTime;
            $('#caution').addClass("hidden");
            $('#go').html(newSummary);
        } else if (direction === 'return') {
            var price_return = parseFloat($(this).data('price-return'));
            var date_return = $('#return-date-' + index).data('date-return');
            date_return_out = date_return;
            var back_id = $("#back_" + index).data('id-return');
            ret_id = back_id;
            newSummary = 'ขากลับ: ' + origin + ' ถึง ' + dest
            + '<br>&nbsp;&nbsp;ราคา : ' + price_return + ' THB<br>&nbsp;&nbsp;เวลา : '
            + departureTime + ' ถึง ' + arriveTime
            + '<br>&nbsp;&nbsp;วันที่กลับ : ' + date_return;
            ret_origin = origin;
            ret_dest = dest;
            ret_price = price_return;
            ret_dep = departureTime;
            ret_arv = arriveTime;
            $('#caution1').addClass("hidden");
            $('#caution').addClass("hidden");
            $('#back').html(newSummary);
        }

		if(isNaN(price_outbound))
		{
			price_outbound = 0;
		}

		if(isNaN(price_return))
		{
			price_return = 0;
		}
        $('#total-price').text('รวมทั้งสิ้น: ' + (extractPrice($('#back').text()) + extractPrice($('#go').text())) + ' THB');
    });

    $("#confirm").click(function () {
        if (($('#go').text() == '' || $('#back').text() == '') && trip_type == 'go-2') {
            $('#caution').removeClass("hidden");
        }
        else if($('#go').text() == '' && trip_type == 'go-1'){
            $('#caution').removeClass("hidden");
        }
        else if(trip_type == 'go-1'){
            window.location.href = "passenger_form.php?" + "&out_id=" + out_id + "&out_origin=" + out_origin + "&out_dest=" + out_dest
            + "&out_price=" + out_price + "&out_dep=" + out_dep + "&out_arv=" + out_arv
            + "&pas_num=" + pas_num + "&trip_type=" + trip_type
            + "&date_out=" + date_out_out;
        }
        else if(trip_type == 'go-2')
        {
            if(date_return_out < date_out_out)
            {
                $('#caution1').removeClass("hidden");
            }
            else if( date_return_out == date_out_out && out_dep > ret_dep)
            {
                $('#caution2').removeClass("hidden");
            }
            else
            {
                window.location.href = "passenger_form.php?" + "&out_id=" + out_id + "&out_origin=" + out_origin + "&out_dest=" + out_dest
            + "&out_price=" + out_price + "&out_dep=" + out_dep + "&out_arv=" + out_arv
            + "&ret_id=" + ret_id + "&ret_origin=" + ret_origin + "&ret_dest=" + ret_dest
            + "&ret_price=" + ret_price + "&ret_dep=" + ret_dep + "&ret_arv=" + ret_arv + "&pas_num=" + pas_num + "&trip_type=" + trip_type
            + "&date_out=" + date_out_out + "&date_return=" + date_return_out;
            }
        }
    });
});
