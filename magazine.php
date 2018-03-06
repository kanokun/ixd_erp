<?php
include_once('header.php');
include_once('nav.php');

$table = "magazine";

// 품목 리스트
$stmt = $dbh->prepare("SELECT * FROM $table ORDER BY month DESC");
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
          <i class="fa fa-table"></i> 잡지 판매현황 차트
        </div>
        
        <div class="row">
    		<div class="date-radio">
    			
    			기간설정 : 
    			
                <input class="date-radio-element" type="radio" id="radio-date-all" name="radio-date" value="all" checked>
                <label for="radio-date-all">전체</label>
            
                <input class="date-radio-element" type="radio" id="radio-date-year" name="radio-date" value="year">
                <label for="radio-date-year">년도별</label>
                
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
                        $_date = substr($row['month'], 0,4);
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
    			<li id="_tab_1" class="_tab _tab_1 active">
            		<a href="#1" data-toggle="tab">ixd</a>
    			</li>
    			<li id="_tab_2" class="_tab _tab_2 active">
            		<a href="#2" data-toggle="tab">데코</a>
    			</li>
    			<li id="_tab_3" class="_tab _tab_3 active">
            		<a href="#3" data-toggle="tab">주락</a>
    			</li>
    		</ul>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
              <!-- Example Bar Chart Card-->
              <div class="card mb-3 card-inside">
                <div class="card-header">
                  <i class="fa fa-bar-chart"></i> 기간별 잡지 판매 권수
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
                          <th>잡지</th>
                          <th>구독자</th>
                          <th>구독만료</th>
                          <th>재구독</th>
                          <th>전화</th>
                          <th>홈페이지</th>
                          <th>더매거진</th>
                          <th>전시</th>
                          <th>기타·지인</th>
                          <th>낱권</th>
                          <th>총판매수</th>
                          <th>비고</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
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
    
<style>
.ui-datepicker-calendar {
    display: none;
}

.ui-datepicker-current {
    display: none;
}
</style>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

<?php include_once('footer.php') ?>


<script>

var _table = null;

Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var _date_ = new Date();
var _date;

var date_first = "201000";
var date_last = _date_.getFullYear() + "99";

var bar_arr = [];
var pie_arr = [];

var query = "";

var myLineChart = null;
var myPieChart = null;

var date_range = "all";
var tab_idx = "0";


function setChartBar() {

    var bar_data = [];

    bar_data['labels'] = [];
    bar_data['datasets'] = [];


	var data_all = [];
	data_all['label'] = "총 판매수";
	data_all['backgroundColor'] = "#ff6384";
	data_all['stack'] = "Stack 1";
	data_all['data'] = [];
	bar_data['datasets'].push(data_all);

	var data_finish = [];
	data_finish['label'] = "구독만료";
	data_finish['backgroundColor'] = "#858585";
	data_finish['stack'] = "Stack 0";
	data_finish['data'] = [];
	bar_data['datasets'].push(data_finish);

	var data_resubscr = [];
	data_resubscr['label'] = "재구독";
	data_resubscr['backgroundColor'] = "#a568ba";
	data_resubscr['stack'] = "Stack 0";
	data_resubscr['data'] = [];
	bar_data['datasets'].push(data_resubscr);
	
	var data_call = [];
	data_call['label'] = "전화";
	data_call['backgroundColor'] = "#1e47a3";
	data_call['stack'] = "Stack 0";
	data_call['data'] = [];
	bar_data['datasets'].push(data_call);

	var data_etc = [];
	data_etc['label'] = "지인·기타";
	data_etc['backgroundColor'] = "#4bc0c0";
	data_etc['stack'] = "Stack 0";
	data_etc['data'] = [];
	bar_data['datasets'].push(data_etc);

	var data_exhibit = [];
	data_exhibit['label'] = "전시";
	data_exhibit['backgroundColor'] = "#ecea21";
	data_exhibit['stack'] = "Stack 0";
	data_exhibit['data'] = [];
	bar_data['datasets'].push(data_exhibit);

	var data_homepage = [];
	data_homepage['label'] = "홈페이지";
	data_homepage['backgroundColor'] = "#ff983c";
	data_homepage['stack'] = "Stack 0";
	data_homepage['data'] = [];
	bar_data['datasets'].push(data_homepage);

	var data_themagazine = [];
	data_themagazine['label'] = "더매거진";
	data_themagazine['backgroundColor'] = "#8a613d";
	data_themagazine['stack'] = "Stack 0";
	data_themagazine['data'] = [];
	bar_data['datasets'].push(data_themagazine);

	var data_unit = [];
	data_unit['label'] = "낱권";
	data_unit['backgroundColor'] = "#8ae572";
	data_unit['stack'] = "Stack 0";
	data_unit['data'] = [];
	bar_data['datasets'].push(data_unit);

	var data_subscr = [];
	data_subscr['label'] = "기존 구독자";
	data_subscr['backgroundColor'] = "#36a2eb";
	data_subscr['stack'] = "Stack 0";
	data_subscr['data'] = [];
	bar_data['datasets'].push(data_subscr);


	for (var k in bar_arr){

		bar_data['labels'].push(k);

		bar_data['datasets'][0]['data'].push(bar_arr[k]['count_all']);
		bar_data['datasets'][1]['data'].push(-bar_arr[k]['count_finish']);
		bar_data['datasets'][2]['data'].push(bar_arr[k]['count_resubscr']);
		bar_data['datasets'][3]['data'].push(bar_arr[k]['count_call']);
		bar_data['datasets'][4]['data'].push(bar_arr[k]['count_etc']);
		bar_data['datasets'][5]['data'].push(bar_arr[k]['count_exhibit']);
		bar_data['datasets'][6]['data'].push(bar_arr[k]['count_homepage']);
		bar_data['datasets'][7]['data'].push(bar_arr[k]['count_themagazine']);
		bar_data['datasets'][8]['data'].push(bar_arr[k]['count_unit']);
		var subscr = bar_arr[k]['count_subscr'] + bar_arr[k]['count_finish'] - bar_arr[k]['count_call'] - bar_arr[k]['count_resubscr'] - bar_arr[k]['count_etc'] - bar_arr[k]['count_exhibit'] - bar_arr[k]['count_homepage'] - bar_arr[k]['count_themagazine'];
		bar_data['datasets'][9]['data'].push(subscr);
    }
	
	// 여기부터 바 차트
	var ctx = document.getElementById("chart-bar");

	if(myLineChart != null)
		myLineChart.destroy();
	
	myLineChart = new Chart(ctx, {
	  type: 'bar',
	  data: bar_data,
	  options: {
          title:{
              display:false,
              text:"잡지 판매현황"
          },
          tooltips: {
              mode: 'index',
              intersect: true
          },
          responsive: true,
          scales: {
              xAxes: [{
                  stacked: true,
              }],
              yAxes: [{
                  stacked: true
              }]
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

	//date_first = "201000";
	//date_last = _date_.getFullYear() + "99";

	query = "SELECT A.*,B.name FROM <?=$table?> A, account B WHERE A.id_acc = B.id AND ";
	query += "(A.month >= " + date_first + " AND A.month <= " + date_last + ")";

	switch(tab_idx){

	case "1":
		query += " AND A.type ='ixd'";
		break;

	case "2":
		query += " AND A.type ='데코'";
		break;

	case "3":
		query += " AND A.type ='주락'";
		break;
	}

	query += " ORDER BY A.month ASC";

	$.ajax({
        dataType:"json",
        url:"db-select-row.php?query=" + query
    }).done(function(data) {


    	if(data == null)
	    	data = [];

    	switch(date_range)
    	{
    	case "all":

        	var _minDate = 999999;
        	var _maxDate = 0;
        	var insert_date;

    		data.forEach(function(e,i){
        		
    			insert_date = parseInt(e['month']);

    			if(_minDate > insert_date)
    				_minDate = insert_date;

    			if(_maxDate < insert_date)
    				_maxDate = insert_date;
    		});

    		insert_date = _minDate.toString();

    		
    		while(parseInt(insert_date) <= _maxDate){

    			_year = insert_date.substring(0,4);
        		_month = insert_date.substring(4,6);

        		_date = _year + "/" + _month;

        		bar_arr[_date] = [];
        		bar_arr[_date]["count_all"] = 0;
                bar_arr[_date]["count_call"] = 0;
                bar_arr[_date]["count_etc"] = 0;
                bar_arr[_date]["count_exhibit"] = 0;
                bar_arr[_date]["count_finish"] = 0;
                bar_arr[_date]["count_homepage"] = 0;
                bar_arr[_date]["count_subscr"] = 0;
                bar_arr[_date]["count_resubscr"] = 0;
                bar_arr[_date]["count_themagazine"] = 0;
                bar_arr[_date]["count_unit"] = 0;

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
	            
	            _date = e['month'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6);


                if(!(e['type'] in pie_arr))
                	pie_arr[e['type']] = 0;


                pie_arr[e['type']] += e["count_all"] * 1;

                bar_arr[_date]["count_all"] += e["count_all"] * 1;
                bar_arr[_date]["count_call"] += e["count_call"] * 1;
                bar_arr[_date]["count_etc"] += e["count_etc"] * 1;
                bar_arr[_date]["count_exhibit"] += e["count_exhibit"] * 1;
                bar_arr[_date]["count_finish"] += e["count_finish"] * 1;
                bar_arr[_date]["count_homepage"] += e["count_homepage"] * 1;
                bar_arr[_date]["count_subscr"] += e["count_subscr"] * 1;
                bar_arr[_date]["count_resubscr"] += e["count_resubscr"] * 1;
                bar_arr[_date]["count_themagazine"] += e["count_themagazine"] * 1;
                bar_arr[_date]["count_unit"] += e["count_unit"] * 1;

	        });
        	
        	break;
    		
    	case "year":

    		for(var i=1; i<13; i++)
    		{
        		var _month = date_first.substring(0,4) + "/" + pad2(i);

    			bar_arr[_month] = [];
        		bar_arr[_month]["count_all"] = 0;
                bar_arr[_month]["count_call"] = 0;
                bar_arr[_month]["count_etc"] = 0;
                bar_arr[_month]["count_exhibit"] = 0;
                bar_arr[_month]["count_finish"] = 0;
                bar_arr[_month]["count_homepage"] = 0;
                bar_arr[_month]["count_subscr"] = 0;
                bar_arr[_month]["count_resubscr"] = 0;
                bar_arr[_month]["count_themagazine"] = 0;
                bar_arr[_month]["count_unit"] = 0;
    		}

			data.forEach(function(e,i){
	            
	            _date = e['month'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6);

                if(!(e['type'] in pie_arr))
                	pie_arr[e['type']] = 0;


                pie_arr[e['type']] += e["count_all"] * 1;

                bar_arr[_date]["count_all"] += e["count_all"] * 1;
                bar_arr[_date]["count_call"] += e["count_call"] * 1;
                bar_arr[_date]["count_etc"] += e["count_etc"] * 1;
                bar_arr[_date]["count_exhibit"] += e["count_exhibit"] * 1;
                bar_arr[_date]["count_finish"] += e["count_finish"] * 1;
                bar_arr[_date]["count_homepage"] += e["count_homepage"] * 1;
                bar_arr[_date]["count_subscr"] += e["count_subscr"] * 1;
                bar_arr[_date]["count_resubscr"] += e["count_resubscr"] * 1;
                bar_arr[_date]["count_themagazine"] += e["count_themagazine"] * 1;
                bar_arr[_date]["count_unit"] += e["count_unit"] * 1;
                
	        });
        	
        	break;

    	case "custom":

        	var insert_date = date_first;
        	var _year, _month;


    		while(parseInt(insert_date) <= parseInt(date_last))
    		{
        		_year = insert_date.substring(0,4);
        		_month = insert_date.substring(4,6);

        		var label_month = _year + "/" + _month;

    			_year = parseInt(_year);
    			_month = parseInt(_month);

    			_month = _month + 1;

    			if(_month > 12)
    			{
        			_month = 1;
        			_year = _year + 1;
    			}

    			insert_date = _year + "" + pad2(_month);


    			bar_arr[label_month] = [];
        		bar_arr[label_month]["count_all"] = 0;
                bar_arr[label_month]["count_call"] = 0;
                bar_arr[label_month]["count_etc"] = 0;
                bar_arr[label_month]["count_exhibit"] = 0;
                bar_arr[label_month]["count_finish"] = 0;
                bar_arr[label_month]["count_homepage"] = 0;
                bar_arr[label_month]["count_subscr"] = 0;
                bar_arr[label_month]["count_resubscr"] = 0;
                bar_arr[label_month]["count_themagazine"] = 0;
                bar_arr[label_month]["count_unit"] = 0;
    		}


			data.forEach(function(e,i){
	            
				_date = e['month'];
	            _date = _date.substring(0,4) + '/' + _date.substring(4,6);

                if(!(e['type'] in pie_arr))
                	pie_arr[e['type']] = 0;


                pie_arr[e['type']] += e["count_all"] * 1;

                bar_arr[_date]["count_all"] += e["count_all"] * 1;
                bar_arr[_date]["count_call"] += e["count_call"] * 1;
                bar_arr[_date]["count_etc"] += e["count_etc"] * 1;
                bar_arr[_date]["count_exhibit"] += e["count_exhibit"] * 1;
                bar_arr[_date]["count_finish"] += e["count_finish"] * 1;
                bar_arr[_date]["count_homepage"] += e["count_homepage"] * 1;
                bar_arr[_date]["count_subscr"] += e["count_subscr"] * 1;
                bar_arr[_date]["count_resubscr"] += e["count_resubscr"] * 1;
                bar_arr[_date]["count_themagazine"] += e["count_themagazine"] * 1;
                bar_arr[_date]["count_unit"] += e["count_unit"] * 1;
	        });
    		
    		break;
    	}

        setChartBar();
        setChartPie();


        // 이 밑으로는 테이블
        var _html = "";

        data.forEach(function(e,i){

        	var _month = e['month'].substring(0,4) + '/' + e['month'].substring(4,6);
        	_html += '<tr><td>' + _month + '</td>';
        	_html += '<td>' + e['type'] + '</td>';
        	_html += '<td>' + e['count_subscr'] + '</td>';
        	_html += '<td>' + e['count_finish'] + '</td>';
        	_html += '<td>' + e['count_resubscr'] + '</td>';
        	_html += '<td>' + e['count_call'] + '</td>';
        	_html += '<td>' + e['count_homepage'] + '</td>';
        	_html += '<td>' + e['count_themagazine'] + '</td>';
        	_html += '<td>' + e['count_exhibit'] + '</td>';
        	_html += '<td>' + e['count_etc'] + '</td>';
        	_html += '<td>' + e['count_unit'] + '</td>';
        	_html += '<td>' + e['count_all'] + '</td>';
        	_html += '<td>' + e['etc'] + '</td></tr>';
        });

        if(_table != null)
        	_table.destroy();

        $("tbody").html(_html);
        
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

		date_first = $("#input-date-year").val() + "00";
		date_last = $("#input-date-year").val() + "99";
		
		break;
		
	case "custom":

		if($("#input-date-custom1").val() == '')
			$("#input-date-custom1").val(_date_.getFullYear() + "/" + pad2(_date_.getMonth()+1));

		if($("#input-date-custom2").val() == '')
			$("#input-date-custom2").val(_date_.getFullYear() + "/" + pad2(_date_.getMonth()+1));

		date_first = $("#input-date-custom1").val().replace(/\//gi,"");
		date_last = $("#input-date-custom2").val().replace(/\//gi,"");
		
		break;
	}

	setChart();
});

$('.date-range-custom input').datepicker({
	monthNamesShort: [ "01", "02", "03", "04","05", "06", "07", "08", "09","10", "11", "12" ],
	changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    showMonthAfterYear: true,
    dateFormat: 'yy/mm',
    onClose: function(dateText, inst) { 
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));

        date_first = $("#input-date-custom1").val().replace(/\//gi,"");
    	date_last = $("#input-date-custom2").val().replace(/\//gi,"");

    	setChart();
    }
});


$("#input-date-year").change(function() {
	
	date_first = $("#input-date-year").val() + "00";
	date_last = $("#input-date-year").val() + "99";
	
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