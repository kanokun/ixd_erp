	<footer class="sticky-footer hide-print">
      <div class="container">
        <div class="text-center">
          <small>Copyright © GamCommunity 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">로그아웃 하시겠습니까?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 출근체크 -->
    <div class="modal fade" id="arrTimeModalPre" tabindex="-1" role="dialog" aria-labelledby="arrTimeModalPreLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="arrTimeModalPreLabel">결근 확인</h5>
          </div>
          <div class="modal-body">
          	<form id="form-add-pre" action="db-modify-arr-time.php" method="post" target="ifr-hidden" >
          		<input type="hidden" name="table" value="arr_time" />
          		<input type="hidden" name="db_type" value="insert" />
          		<input type="hidden" name="late" value="-1" />
          		<input type="hidden" id="input-pre-time" name="time" />

          		<div class="arrTimeModalPre-date"></div>

          		<div class="row">
                  	<div class="arrTimeModal-date"></div>
              	</div>

              	<div class="arrTimeModal-reason">
              		<div>
                  		<input type="radio" name="reason_type" value="결근" checked="checked" /> 결근
                  		<input type="radio" name="reason_type" value="외근" /> 외근
                  		<input type="radio" name="reason_type" value="기타" /> 기타
              		</div>
                    <textarea class="form-control" id="input-pre-reason" name="reason" placeholder="사유"></textarea>
              	</div>
          	</form>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary btn-arr-time-ok-pre" >확인</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="arrTimeModal" tabindex="-1" role="dialog" aria-labelledby="arrTimeModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="arrTimeModalLabel">출근 체크</h5>
          </div>
          <div class="modal-body">

          	<form id="form-add" action="db-modify-arr-time.php" method="post" target="ifr-hidden" >
          		<input type="hidden" name="table" value="arr_time" />
          		<input type="hidden" name="db_type" value="insert" />
          		<input type="hidden" id="input-late" name="late" />
          		<input type="hidden" id="input-time" name="time" />
          		<input type="hidden" id="input-compare-time" name="compare-time" />

              	<div class="row">
                  	<div class="arrTimeModal-date"></div><div class="arrTimeModal-time"></div>
              	</div>
              	<div class="arrTimeModal-time-compare">
    			</div>
              	<div class="arrTimeModal-reason _hide">
              		<div>
                  		<input type="radio" name="reason_type" value="지각" checked="checked" /> 지각
                  		<input type="radio" name="reason_type" value="외근" /> 외근
                  		<input type="radio" name="reason_type" value="기타" /> 기타
              		</div>
                    <textarea class="form-control" id="input-reason" name="reason" placeholder="사유"></textarea>
              	</div>
          	</form>

          </div>
          <div class="modal-footer">
            <a class="btn btn-primary btn-arr-time-ok" >확인</a>
          </div>
        </div>
      </div>
  	</div>
  </div>

  	<iframe id="ifr-hidden" name="ifr-hidden" width=0 height=0></iframe>

	<!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="vendor/jquery.number.js"></script>
	<script src="vendor/excelexport.js"></script>
	<script src="vendor/jquery.battatech.excelexport.js"></script>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <script src="vendor/monthly/js/monthly.js"></script>
    <script src="vendor/jpicker/js/jpicker-1.1.6.js"></script>

    <script src="js/common.js"></script>

<script>

<?php
$stmt = $dbh->prepare("SELECT * FROM holiday WHERE id_acc=".$_SESSION['id']." AND count<0 ORDER BY date_start DESC");
$stmt->execute();
$list_holiday = $stmt->fetchAll();

?>
var obj_holiday = [];
var obj;
<?php
foreach($list_holiday as $row){

    $date_start = $row['date_start'];
    $date_start = $row['count'];    
?>
obj = new Object();
obj.date = "<?=$row['date_start']?>";
obj.count = Math.abs(<?=$row['count']?>);
obj_holiday.push(obj);
<?php
}

$stmt = $dbh->prepare("SELECT * FROM arr_time WHERE id_acc=".$_SESSION['id']." ORDER BY time DESC LIMIT 1");
$stmt->execute();
$list = $stmt->fetchAll();

$time = date('Y-m-d');
$today = strtotime($time);

foreach($list as $row){

    $time = explode(" ", $row['time'])[0];
    
    $time = date("Y-m-d", strtotime($time." +1 days"));
}


if($_time <= $today) {
?>

function arrTimeCheck(_date) {

	// 확인날짜가 오늘보다 이후면 리턴.
	var today = new Date();
	today = today.getFullYear()+pad2(today.getMonth()+1)+pad2(today.getDate());

	var checkday = _date.replace(/-/gi,"");

	if(parseInt(checkday) > parseInt(today))
		return;


	var arrDate = _date.split('-');
	var check_weekend = new Date(_date).getDay();

	if(check_weekend == '0' || check_weekend == '6'){

		// 주말이므로 다음날로 패스.
		_date = new Date(arrDate[0], (arrDate[1]-1), arrDate[2]);
		_date.setDate(_date.getDate() + 1);
		_date = _date.getFullYear()+'-'+pad2(_date.getMonth()+1)+'-'+pad2(_date.getDate());

		arrTimeCheck(_date);

		return;
	}

	var holiday_arrDate;
	var holiday_date;

	// 휴가인지 체크
	for(var i=0; i<obj_holiday.length; i++)
	{
		holiday_arrDate = obj_holiday[i].date.split('/');

		for(var j=0; j<obj_holiday[i].count; j++)
		{
			holiday_date = new Date(holiday_arrDate[0], (holiday_arrDate[1]-1), holiday_arrDate[2]);
			holiday_date.setDate(holiday_date.getDate() + j);
			holiday_date = holiday_date.getFullYear()+'-'+pad2(holiday_date.getMonth()+1)+'-'+pad2(holiday_date.getDate());

			if(_date == holiday_date)
			{
				_date = new Date(arrDate[0], (arrDate[1]-1), arrDate[2]);
				_date.setDate(_date.getDate() + 1);
				_date = _date.getFullYear()+'-'+pad2(_date.getMonth()+1)+'-'+pad2(_date.getDate());
				
				arrTimeCheck(_date);

				return;
			}
		}
	}

	
	$("#input-pre-time").val(_date);
	$(".arrTimeModal-date").html(_date);

	$.ajax({
	    url: 'https://apis.sktelecom.com/v1/eventday/days',
	    headers: {
	        'TDCProjectKey':'4b8016ea-592c-48d7-a877-6985a4ba969e',
	    },
	    method: 'GET',
	    dataType: 'json',
	    data: { 'type':'h', 'year':arrDate[0], 'month':arrDate[1], 'day':arrDate[2] },
	    success: function(data){

	      if(data.totalResult == 0){

	    	  // 여기서 모달.
	    	  var date_now = new Date();
	    	  var date1 = $(".arrTimeModal-date").html();
	    	  var date2 = date_now.getFullYear() + '-' + pad2(date_now.getMonth()+1) + '-' + pad2(date_now.getDate());

	    	  if(date1 == date2)	// 오늘
	    	  {
	    		  var time1 = new Date(date1);

		    	  time1.setHours(9);
		    	  time1.setMinutes(0);
		    	  time1.setSeconds(0);

		    	  var compare_time = date_now.getTime() - time1.getTime();
		    	  var compare_time_abs = Math.abs(compare_time);

		    	  var second = Math.floor(compare_time_abs/1000%60);
		    	  var minute = Math.floor(compare_time_abs/1000/60%60);
		    	  var hour = Math.floor(compare_time_abs/1000/60/60);
		    	  var output_compare_time = "";

				  var output_time = "";

		    	  if(compare_time < 0) {
			    	  $("#input-late").val(0);
		    		  output_compare_time += "-" + pad2(hour) + ":" + pad2(minute) + ":" + pad2(second);
		    		  output_time += "<span style='color:green;'>정시출근 -" + pad2(hour) + ":" + pad2(minute) + ":" + pad2(second);

		    		  $(".arrTimeModal-reason").addClass("_hide");
		    	  }else{
		    		  $("#input-late").val(1);
		    		  output_compare_time += "+" + pad2(hour) + ":" + pad2(minute) + ":" + pad2(second);
		    		  output_time += "<span style='color:red;'>지각 +" + pad2(hour) + ":" + pad2(minute) + ":" + pad2(second);

		    		  $(".arrTimeModal-reason").removeClass("_hide");
		    	  }
		    	  
		    	  output_time += "</span>";
		    	  

		    	  $(".arrTimeModal-time-compare").html(output_time);

		    	  output_time = pad2(date_now.getHours()) + ":" + pad2(date_now.getMinutes()) + ":" + pad2(date_now.getSeconds()); 
		    	  $(".arrTimeModal-time").html(output_time);

				  $("#input-time").val(date1 + " " + output_time);
			      $("#input-compare-time").val(output_compare_time);

		    	  $("#arrTimeModal").modal();
		    	  
	    	  }else{				// 지난 날 결격 사유 체크.

	    		  $("#arrTimeModalPre").modal('show');
	    	  }
	    	  
	      }else{

	    	  // 휴일이므로 다음날로 패스.
		      var _d = new Date(data.results[0].year, (data.results[0].month-1), data.results[0].day);
			  _d.setDate(_d.getDate() + 1);
			  _d = _d.getFullYear()+'-'+pad2(_d.getMonth()+1)+'-'+pad2(_d.getDate());

			  arrTimeCheck(_d);
	      }
	    }
	});	
}

<?php
if($_SESSION['level']<=11){
?>

arrTimeCheck("<?=$time?>");

<?php
}
?>

$(".btn-arr-time-ok").click(function(){

	$("#arrTimeModal").modal('toggle');
	$("#form-add").submit();
});

$(".btn-arr-time-ok-pre").click(function(){

	$("#arrTimeModalPre").modal('toggle');
	$("#form-add-pre").submit();

	var _date = $("#input-pre-time").val();
	var arrDate = _date.split('-');

	var _d = new Date(arrDate[0], arrDate[1], arrDate[2]);
		_d.setDate(_d.getDate() + 1);
		_d = _d.getFullYear()+'-'+pad2(_d.getMonth())+'-'+pad2(_d.getDate());

	arrTimeCheck(_d);
});

<?php
}
?>

</script>