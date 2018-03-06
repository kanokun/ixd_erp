<?php
include_once('header.php');
include_once('nav.php');

$table = "purchase";

// 자회사 리스트
$stmt = $dbh->prepare("SELECT * FROM company_self ORDER BY id DESC");
$stmt->execute();
$company_self_list = $stmt->fetchAll();

// 매입처 회사 리스트
$stmt = $dbh->prepare("SELECT * FROM company ORDER BY name ASC");
$stmt->execute();
$company_list = $stmt->fetchAll();

// 품목 리스트
$stmt = $dbh->prepare("SELECT * FROM type_purchase ORDER BY name ASC");
$stmt->execute();
$type_list = $stmt->fetchAll();

if($_SESSION['level'] > 9){
    $stmt = $dbh->prepare("SELECT A.*,B.name as company_self_name, C.name as company_name, D.name as type_name, E.name as acc_name FROM $table A, company_self B, company C, type_purchase D, account E WHERE A.id_comp_self = B.id AND A.id_comp = C.id AND A.id_type = D.id AND A.id_acc = E.id ORDER BY date DESC");
}else{
    $stmt = $dbh->prepare("SELECT A.*,B.name as company_self_name, C.name as company_name, D.name as type_name, E.name as acc_name FROM $table A, company_self B, company C, type_purchase D, account E WHERE A.id_comp_self = B.id AND A.id_comp = C.id AND A.id_type = D.id AND A.id_acc = E.id AND A.id_acc = ".$_SESSION['id']." ORDER BY date DESC");
}

$stmt->execute();
$list = $stmt->fetchAll();
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">매입</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 매입 관련 차트
        </div>
        
        <div class="row">
    		<div class="date-radio">
    			
    			기간설정 : 
    			
                <input class="date-radio-element" type="radio" id="radio-date-all" name="radio-date" value="all" checked>
                <label for="radio-date-all">전체</label>
            
                <input class="date-radio-element" type="radio" id="radio-date-year" name="radio-date" value="year">
                <label for="radio-date-year">년도별</label>
            
                <input class="date-radio-element" type="radio" id="radio-date-month" name="radio-date" value="month">
                <label for="radio-date-month">월별</label>
                
                <input class="date-radio-element" type="radio" id="radio-date-custom" name="radio-date" value="custom">
                <label for="radio-date-custom">범위</label>
            </div>
            <div class="date-range">
            	<div class="date-range-element date-range-year _hide">
                	<select class="form-control date-range-input" id="input-date-year" name="date-year">
					<?php
					$min = 9999;
					$max = 0;
					
					$arr_year = [];

                    foreach($list as $row){
                        $_date = substr($row['date'], 0,4);
                        $arr_year[$_date] = $_date;
                    }
                    
                    foreach($arr_year as $row){
                    ?>
                    	<option value=<?=$row?>><?=$row?></option>
                    <?php
                    }
                    ?>
                    </select>
            	</div>
            	<div class="date-range-element date-range-month _hide">
                	<select class="form-control date-range-input " id="input-date-month1" name="date" >
                	<?php
                	foreach($arr_year as $row){
                	?>
                    	<option value=<?=$row?>><?=$row?></option>
                    <?php
                    }
                    ?>
                	</select>
                	<select class="form-control date-range-input " id="input-date-month2" name="date" >
                	<?php
                	for($i=1; $i<13; $i++){
                	    $j = str_pad($i,"2","0",STR_PAD_LEFT);
                	?>
                    	<option value=<?=$j?>><?=$j?></option>
                    <?php
                    }
                    ?>
                	</select>
            	</div>
            	<div class="date-range-element date-range-custom _hide">
                	<input class="form-control date-range-input" id="input-date-custom1" name="date" type="text" > ~
                	<input class="form-control date-range-input" id="input-date-custom2" name="date" type="text" >
            	</div>
            </div>
        </div>
        
        <div class="card-body card-tab">
        
        	<ul class="nav nav-tabs">
    			<li id="_tab_0" class="_tab _tab_0 active">
            		<a href="#0" data-toggle="tab">전체</a>
    			</li>
    			<?php
    			$i=0;
    			foreach($company_self_list as $row){
    			    $i++;
    			?>
    			<li id="_tab_<?=$row['id']?>" class="_tab _tab_<?=$i?>">
    				<a href="#<?=$i?>" data-toggle="tab"><?=$row['name']?></a>
    			</li>
    			<?php
    			}
    			?>
    		</ul>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
              <!-- Example Bar Chart Card-->
              <div class="card mb-3 card-inside">
                <div class="card-header">
                  <i class="fa fa-bar-chart"></i> 기간별 매입액
                  <div class="card-toggle"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
                </div>
                <div class="card-body">
                  <canvas id="chart-bar" width="100" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- Example Pie Chart Card-->
              <div class="card mb-3 card-inside">
                <div class="card-header">
                  <i class="fa fa-pie-chart"></i> 기간별 매입 품목
                  <div class="card-toggle"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
                </div>
                <div class="card-body">
                  <canvas id="chart-pie" width="100%" height="100"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
              </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
              <!-- Example Bar Chart Card-->
              <div class="card mb-3 card-inside">
                <div class="card-header">
                  <i class="fa fa-table"></i> 매출 리스트
                  <div class="card-toggle"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>날짜</th>
                          <th>회사명</th>
                          <th>거래처</th>
                          <th>품목</th>
                          <th>상세</th>
                          <th>지불종류</th>
                          <th>금액</th>
                          <th>부가세</th>
                          <th>총액</th>
                          <th>비고</th>
                          <th>상태</th>
                          <th>등록인</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer small text-muted card-footer-cost">
                	<span>
						총 금액 : 
					</span>
					<span class="all-cost">
						0
					</span>
					<span>
						원 / 총 부가세 : 
					</span>
					<span class="all-tax">
						0
					</span>
					<span>
						원 / 총액 : 
					</span>
					<span class="all-final-cost">
						0
					</span>
					<span>
						원
					</span>
				</div>
              </div>
            </div>
        </div>
      </div>
    </div>
    
    
    <div class="modal fade modal-company-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form>
    				<input type="hidden" id="input2-id" name="id" value="">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="input2-name" class="label-need">회사명</label>
                         <input class="form-control input2" id="input2-name" name="name" type="text" placeholder="회사명" readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="input2-email">이메일</label>
                        <input class="form-control input2" id="input2-email" name="email" type="text" placeholder="이메일 주소" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="input2-phone" >전화번호</label>
                         <input class="form-control input2" id="input2-phone" name="phone" type="text" placeholder="전화번호" readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="input2-fax">팩스</label>
                        <input class="form-control input2" id="input2-fax" name="fax" type="text" placeholder="팩스번호" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="input2-admin">담당자</label>
                        <input class="form-control input2" id="input2-admin" name="admin" type="text" placeholder="담당자" readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="input2-code">사업자 등록번호</label>
                        <input class="form-control input2" id="input2-code" name="code" type="text" placeholder="사업자 등록번호" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input2-etc">비고</label>
                        <textarea class="form-control" id="input2-etc" name="etc" placeholder="비고" readonly></textarea>
                      </div>
                    </div>
                  </div>
              </form>
			</div>
		</div>
    </div>
    
    <div class="modal fade modal-type-purchase-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form>
    				<input type="hidden" id="input3-id" name="id" value="">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input3-name" class="label-need">품목 명</label>
                         <input class="form-control input3" id="input3-name" name="name" type="text" placeholder="품목 명" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input3-etc">비고</label>
                        <textarea class="form-control" id="input3-etc" name="etc" placeholder="비고" readonly></textarea>
                      </div>
                    </div>
                  </div>
              </form>
			</div>
		</div>
    </div>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

<?php include_once('footer.php') ?>

<script>

var _table = null;

Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var _date_ = new Date();
var _date;

var date_first = "20100000";
var date_last = _date_.getFullYear() + "9999";

var bar_arr = [];
var pie_arr = [];
var _cost;

var query = "";

var myLineChart = null;
var myPieChart = null;

var date_range = "all";
var tab_idx = "0";


function setChartBar() {

	var bar_label = [];
    var bar_value = [];
    

	for (var k in bar_arr){
        
        bar_label.push(k);
        bar_value.push(bar_arr[k]);
    }

	// 여기부터 바 차트
	var ctx = document.getElementById("chart-bar");

	if(myLineChart != null)
		myLineChart.destroy();
	
	myLineChart = new Chart(ctx, {
	  type: 'bar',
	  data: {
	    labels: bar_label,
	    datasets: [{
	      label: "매입액",
	      backgroundColor: "rgba(2,117,216,1)",
	      borderColor: "rgba(2,117,216,1)",
	      data: bar_value,
	    }],
	  },
	  options: {
	    scales: {
	      xAxes: [{
	        time: {
	          unit: 'month'
	        },
	        gridLines: {
	          display: false
	        },
	        ticks: {
	          maxTicksLimit: 6
	        }
	      }],
	      yAxes: [{
	        ticks: {
	          maxTicksLimit: 10,
	          beginAtZero:true,

		        callback: function(value, index, values) {
		        	if(parseInt(value) >= 1000){
	                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	                 } else {
		                 if(value <= 1)
		                	 value = Math.floor(value * 10);
	                    return value;
	                 }
		        }
	        },
	        gridLines: {
	          display: true
	        }
	        
	      }],
	    },
	    legend: {
	      display: true
	    },
	    tooltips: {
		    callbacks: {
			    label: function(tooltipItem, data) {
					var value = data.datasets[0].data[tooltipItem.index];
					value = value.toString();
					value = value.split(/(?=(?:...)*$)/);
					value = value.join(',');
					return value;
			    }
		    }
	    }
	  }
	});
}

function setChartPie() {

	var pie_label = [];
    var pie_value = [];
    var pie_color = [];

	for (var k in pie_arr){
        
        pie_label.push(k);
        pie_value.push(pie_arr[k]);
    }
    for(var i=0; i<pie_value.length; i++){
        
    	pie_color.push(random_rgba());
    }

	var ctx = document.getElementById("chart-pie");

	if(myPieChart != null)
		myPieChart.destroy();
	
	myPieChart = new Chart(ctx, {
	  type: 'pie',
	  data: {
	    labels: pie_label,
	    datasets: [{
	      data: pie_value,
	      backgroundColor: pie_color,
	    }],
	  },

	  options: {
		  tooltips: {
			    callbacks: {
				    label: function(tooltipItem, data) {
						var value = data.datasets[0].data[tooltipItem.index];
						value = value.toString();
						value = value.split(/(?=(?:...)*$)/);
						value = value.join(',');
						
						return data.labels[tooltipItem.index] + ": " + value;
				    }
			    }
		    }
	  }
	});
}

function setChart() {

	bar_arr = [];
	pie_arr = [];

	//date_first = "20100000";
	//date_last = _date_.getFullYear() + "9999";

	query = "SELECT A.*,B.name as company_self_name, C.name as company_name, D.name as type_name, E.name as acc_name FROM <?=$table?> A, company_self B, company C, type_purchase D, account E WHERE A.id_comp_self = B.id AND A.id_comp = C.id AND A.id_type = D.id AND A.id_acc = E.id AND ";
	query += "(A.date >= " + date_first + " AND A.date <= " + date_last + ")";

	if(tab_idx != "0")
		query += " AND A.id_comp_self =" + tab_idx;

	<?php
	if($_SESSION['level'] <= 9){
	?>
		query += "AND A.id_acc = <?=$_SESSION['id']?> ";
	<?php
	}
	?>
	
	query += " ORDER BY A.date ASC";


	$.ajax({
        dataType:"json",
        url:"db-select-row.php?query=" + query
    }).done(function(data) {

    	if(data == null)
	    	data = [];


    	switch(date_range)
    	{
    	case "all":

        	var _minDate = 99999999;
        	var _maxDate = 0;
        	var insert_date;

    		data.forEach(function(e,i){
        		
    			insert_date = parseInt(e['date'].substring(0, 6));

    			if(_minDate > insert_date)
    				_minDate = insert_date;

    			if(_maxDate < insert_date)
    				_maxDate = insert_date;
    		});
    		

    		insert_date = _minDate.toString();

    		while(parseInt(insert_date) <= _maxDate){

    			_year = insert_date.substring(0,4);
        		_month = insert_date.substring(4,6);

        		bar_arr[_year + "/" + _month] = 0;

    			_year = parseInt(_year);
    			_month = parseInt(_month);

    			_month = _month + 1;
    			
    			if(_month > 12)
    			{
        			_month = 1;
        			_year = _year + 1;
    			}

    			insert_date = _year + "" + pad2(_month);
    		}
    		

			data.forEach(function(e,i){
	            
	            _date = e['date'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6);

	            if(!(_date in bar_arr))
	                bar_arr[_date] = 0;

                if(!(e['type_name'] in pie_arr))
                	pie_arr[e['type_name']] = 0;
                    
	            
	            _cost = e['cost']*1 + e['tax']*1;
	            
	            bar_arr[_date] += _cost;
	            pie_arr[e['type_name']] += _cost;
	        });
        	
        	break;
    		
    	case "year":

    		for(var i=1; i<13; i++)
    			bar_arr[date_first.substring(0,4) + "/" + pad2(i)] = 0;

			data.forEach(function(e,i){
	            
	            _date = e['date'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6);

	            if(!(_date in bar_arr))
	                bar_arr[_date] = 0;

                if(!(e['type_name'] in pie_arr))
                	pie_arr[e['type_name']] = 0;
                    
	            
	            _cost = e['cost']*1 + e['tax']*1;
	            
	            bar_arr[_date] += _cost;
	            pie_arr[e['type_name']] += _cost;
	        });
        	
        	break;

    	case "month":

    		for(var i=1; i<32; i++)
    			bar_arr[date_first.substring(0,4) + "/" + date_first.substring(4,6) + "/" + pad2(i)] = 0;

			data.forEach(function(e,i){
	            
	            _date = e['date'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6) + '/' + _date.substring(6,8);

	            if(!(_date in bar_arr))
	                bar_arr[_date] = 0;

                if(!(e['type_name'] in pie_arr))
                	pie_arr[e['type_name']] = 0;
                    
	            
	            _cost = e['cost']*1 + e['tax']*1;
	            
	            bar_arr[_date] += _cost;
	            pie_arr[e['type_name']] += _cost;
	        });
	        
        	break;

    	case "custom":

        	var insert_date = date_first;
        	var _year, _month, _day;
        	

    		while(parseInt(insert_date) <= parseInt(date_last))
    		{
        		_year = insert_date.substring(0,4);
        		_month = insert_date.substring(4,6);
        		_day = insert_date.substring(6,8);
        		
    			bar_arr[_year + "/" + _month + "/" + _day] = 0;

    			_year = parseInt(_year);
    			_month = parseInt(_month);
    			_day = parseInt(_day);

    			_day = _day + 1;
    			
    			if(_day > 31)
    			{
        			_day = 1;
        			_month = _month + 1;

        			if(_month > 12)
        			{
            			_month = 1;
            			_year = _year + 1;
        			}        			
    			}

    			insert_date = _year + "" + pad2(_month) + "" + pad2(_day);
    		}


			data.forEach(function(e,i){
	            
	            _date = e['date'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6) + '/' + _date.substring(6,8);

	            if(!(_date in bar_arr))
	                bar_arr[_date] = 0;

                if(!(e['type_name'] in pie_arr))
                	pie_arr[e['type_name']] = 0;
                    
	            
	            _cost = e['cost']*1 + e['tax']*1;
	            
	            bar_arr[_date] += _cost;
	            pie_arr[e['type_name']] += _cost;
	        });
    		
    		break;
    	}

        setChartBar();
        setChartPie();


        // 이 밑으로는 테이블
        var _html = "";

        var _all_cost = 0;
        var _all_tax = 0;
        var _all_final_cost = 0;

        data.forEach(function(e,i){

        	var final_cost = (e['cost']*1) + (e['tax']*1);

        	_html += '<tr><td>' + e['date'] + '</td>';
        	_html += '<td>' + e['company_self_name'] + '</td>';
        	_html += '<td class="td-btn">' + e['company_name'] + '<a class="btn btn-sm btn-primary btn-company-info" id="btn-company-info-' + e['id_comp'] + '" >+</a></td>';
        	_html += '<td class="td-btn">' + e['type_name'] + '<a class="btn btn-sm btn-primary btn-type-info" id="btn-type-info-' + e['id_type'] + '" >+</a></td>';
        	_html += '<td>' + e['type_detail'] + '</td>';
        	_html += '<td>' + e['cost_type'] + '</td>';
        	_html += '<td class="td-text-right">' + comma(e['cost']) + '</td>';
        	_html += '<td class="td-text-right">' + comma(e['tax']) + '</td>';
        	_html += '<td class="td-text-right">' + comma(final_cost) + '</td>';
        	_html += '<td>' + e['etc'] + '</td>';
        	_html += '<td>' + e['state'] + '</td>';
        	_html += '<td>' + e['acc_name'] + '</td></tr>';

        	_all_cost += parseInt(e['cost']);
        	_all_tax += parseInt(e['tax']);
        	_all_final_cost += final_cost;
        });

        if(_table != null)
        	_table.destroy();

        $("tbody").html(_html);

        $(".all-cost").html(comma(_all_cost));
        $(".all-tax").html(comma(_all_tax));
        $(".all-final-cost").html(comma(_all_final_cost));
        
        _table = $('#dataTable').DataTable({
          "order": [[0, "desc"]]
        });
    });
}



$("._tab").click(function(){	

	$("._tab").removeClass("active");
	$(this).addClass("active");

	var _id = $(this).attr('id').split('_');
	_id = _id[_id.length-1];

	tab_idx = _id;

	setChart();
});

$(".date-radio-element").click(function(){

	var _type = $(this).attr('id').split('-');
	_type = _type[_type.length-1];
	date_range = _type;

	$(".date-range-element").addClass("_hide");
	$(".date-range-" + _type).removeClass("_hide");

	switch(_type){

	case "all":
		date_first = "00000000";
		date_last = "99999999";
		
		break;
	
	case "year":
		
		if($("#input-date-year").val() == '')
			$("#input-date-year").val(_date_.getFullYear());

		date_first = $("#input-date-year").val() + "0000";
		date_last = $("#input-date-year").val() + "9999";
		
		break;
		
	case "month":
		
		if($("#input-date-month1").val() == '')
			$("#input-date-month1").val(_date_.getFullYear());

		if($("#input-date-month2").val() == '')
			$("#input-date-month2").val(pad2(_date_.getMonth()+1));
		

		date_first = $("#input-date-month1").val() + $("#input-date-month2").val() + "00";
		date_last = $("#input-date-month1").val() + $("#input-date-month2").val() + "99";
		
		break;
		
	case "custom":

		if($("#input-date-custom1").val() == '')
			$("#input-date-custom1").val(_date_.getFullYear() + "/" + pad2(_date_.getMonth()+1) + "/" + pad2(_date_.getDay()));

		if($("#input-date-custom2").val() == '')
			$("#input-date-custom2").val(_date_.getFullYear() + "/" + pad2(_date_.getMonth()+1) + "/" + pad2(_date_.getDay()));

		date_first = $("#input-date-custom1").val().replace(/\//gi,"");
		date_last = $("#input-date-custom2").val().replace(/\//gi,"");
		
		break;
	}

	setChart();
});

$(".date-range-custom input").datepicker({
    changeYear:true,
    dateFormat: "yy/mm/dd"
});

$("#input-date-year").change(function() {
	
	date_first = $("#input-date-year").val() + "0000";
	date_last = $("#input-date-year").val() + "9999";
	
	setChart();
});

$(".date-range-month select").change(function() {
	
	date_first = $("#input-date-month1").val() + $("#input-date-month2").val() + "00";
	date_last = $("#input-date-month1").val() + $("#input-date-month2").val() + "99";
	
	setChart();
});

$(".date-range-custom input").change(function() {
	date_first = $("#input-date-custom1").val().replace(/\//gi,"");
	date_last = $("#input-date-custom2").val().replace(/\//gi,"");

	setChart();
});

$("._tab_0 a").click();


// 이 밑으로는 테이블
$('body').on('click', '.btn-company-info', function() {

	var id = $(this).attr('id').split('-');
    id = id[id.length-1];

    $.ajax({
        dataType:"json",
        url:"db-select-row.php?query=SELECT * FROM company WHERE `id`=" + id + " limit 1"
    }).done(function(data) {
    	
    	$("#input2-name").val(data[0].name);
    	$("#input2-email").val(data[0].email);
    	$("#input2-phone").val(data[0].phone);
    	$("#input2-fax").val(data[0].fax);
    	$("#input2-admin").val(data[0].admin);
    	$("#input2-code").val(data[0].code);
    	$("#input2-etc").val(data[0].etc);
    	
    	$(".modal-company-info").modal();
    });
});

//이 밑으로는 테이블
$('body').on('click', '.btn-type-info', function() {

	var id = $(this).attr('id').split('-');
    id = id[id.length-1];

    $("#input-id").val(id);

    $.ajax({
        dataType:"json",
        url:"db-select-row.php?query=SELECT * FROM type_<?=$table?> WHERE `id`=" + id + " limit 1"
    }).done(function(data) {
    	
    	$("#input3-name").val(data[0].name);
    	$("#input3-etc").val(data[0].etc);
    	
    	$(".modal-type-purchase-info").modal();
    });
});
</script>