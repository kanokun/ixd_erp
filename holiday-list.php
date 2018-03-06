<?php
include_once('header.php');
include_once('nav.php');

$table = "draft_holiday";
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">휴가 승인</li>
      </ol>
      <!-- Example DataTables Card-->

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 휴가신청 리스트
        </div>

        <div class="card-body card-tab">

        	<ul class="nav nav-tabs">
    			<li id="_tab_0" class="_tab _tab_0 active">
            		<a href="#0" data-toggle="tab">전체</a>
    			</li>
    			<li id="_tab_1" class="_tab _tab_1">
            		<a href="#1" data-toggle="tab">완료</a>
    			</li>
    			<li id="_tab_2" class="_tab _tab_2">
            		<a href="#2" data-toggle="tab">미완료</a>
    			</li>
    			<li id="_tab_3" class="_tab _tab_3">
            		<a href="#3" data-toggle="tab">기각</a>
    			</li>
    		</ul>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>등록일</th>
                  <th>작성자</th>
                  <th>비고</th>
                  <th>휴가날짜</th>
                  <th>일수</th>
                  <th>상태</th>
                  <th>사유</th>
                  <th>기타</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">휴가 신청 리스트 입니다.</div>
      </div>
    </div>
    
    <div class="modal fade modal-holiday" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form-holiday" action="./db-modify-holiday.php" method="post" target="ifr-hidden">
    				<input type="hidden" id="input-id" name="id" >
            		<input type="hidden" name="table" value="draft_holiday">
            		<input type="hidden" name="db_type" value="update">
            		<input type="hidden" id="input-type" name="type" value="">
            		<input type="hidden" id="input-level" name="level" value="">
    				
                  	<div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input-reason">기각 사유를 적어주세요.</label>
                        <textarea class="form-control" id="input-reason" name="reason" placeholder="사유" ></textarea>
                        
                        <a class="btn btn-sm btn-primary btn-ok">확인</a>
        				<a class="btn btn-sm btn-primary btn-cancel">취소</a>
                      </div>
                    </div>
                  </div>
              </form>
			</div>
		</div>
    </div>

<?php include_once('footer.php') ?>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script>

    var tab_idx = "0";

    function setDraft() {

    	var query = "SELECT A.*, B.name FROM <?=$table?> A, account B ";
    	var where = "";

    	if(tab_idx == "1")
    		where += "AND A.level = 10 ";
    	else if(tab_idx == "2")
        	where += "AND (A.level != 10 AND A.level >= 0) ";
    	else if(tab_idx == "3")
        	where += "AND A.level < 0 ";

    	query += "WHERE A.id_acc = B.id ";
        	
    	if(where.length != 0)
        	query += where;
    	
    	query += "ORDER BY date DESC";
    	

    	$.ajax({
            dataType:"json",
            url:"db-select-row.php?query=" + query
        }).done(function(data) {
        	
            // 이 밑으로는 테이블
            var _html = "";
            var _level = "";

            if(data != null){
                
            	data.forEach(function(e,i){

            		switch(e['level'])
					{
                    case "-3":
                    	_level = "<span style='color:red;'>대표님 기각</span>";
                        break;
                    case "-2":
                    	_level = "<span style='color:red;'>이사님 기각</span>";
                        break;
                    case "-1":
                    	_level = "<span style='color:red;'>과장님 기각</span>";
                        break;
                    case "0":
                    	_level = "과장님 승인 대기";
                        break;
                    case "1":
                    	_level = "이사님 승인 대기";
                        break;
                    case "2":
                    	_level = "대표님 승인 대기";
                        break;
                    case "10":
                    	_level = "<span style='color:blue;'>승인 완료</span>";
                        break;
                    }

                	_html += '<tr><td>'+e['date']+'</td>';
                	_html += '<td>'+e['name']+'</td>';
                	_html += '<td>'+e['etc']+'</td>';
                	_html += '<td>'+e['date_start']+'</td>';
                	_html += '<td>'+e['count']+'</td>';
                	_html += '<td class="level_val" id="level_val_' + e['id'] + '"  data-val=' + e['level'] + ' >'+_level+'</td>';
                	_html += '<td>'+e['reason']+'</td>';

                	var _check = false;
                	<?php                	
                	if($_SESSION['id'] == 11 || $_SESSION['level'] == 100) {
                	?>
                	if(e['level'] == "0")
                		_check = true;
                	<?php
                	}elseif($_SESSION['id'] == 13 || $_SESSION['level'] == 100) {
                	?>
                	if(e['level'] == "1")
                		_check = true;
                	<?php
                	}elseif($_SESSION['id'] == 12 || $_SESSION['level'] == 100){
                	?>
                	if(e['level'] == "2")
                		_check = true;
                	<?php
                    }
                    ?>

                	if(_check){
                    	_html += '<td><a class="btn btn-sm btn-primary btn-hdraft-allow btn-hdraft-info-first" id="btn-hdraft-info-' + e['id'] + '" >승인</a>';
                    	_html += '<a class="btn btn-sm btn-primary btn-hdraft-reject" id="btn-hdraft-info-' + e['id'] + '">기각</a></td></tr>';
                	}else{
                        _html += '<td></td></tr>';
                	}
                });
            }

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

    	setDraft();
    });


    $('body').on('click', '.btn-hdraft-allow', function() {
        
    	var _idx = $(this).attr('id').split('-');
    	_idx = _idx[_idx.length-1];

    	
    	$("#input-level").val($("#level_val_"+_idx).attr('data-val'));
    	$("#input-id").val(_idx);
    	$("#input-type").val("allow");
    	$("#form-holiday").submit();
    });

	$('body').on('click', '.btn-hdraft-reject', function() {

		var _idx = $(this).attr('id').split('-');
    	_idx = _idx[_idx.length-1];

    	$("#input-level").val($("#level_val_"+_idx).attr('data-val'));
    	$("#input-id").val(_idx);
    	$("#input-type").val("reject");
    	
		$(".modal-holiday").modal();
    });

    $(".btn-ok").click(function(){
    	$("#form-holiday").submit();
    });

	$(".btn-cancel").click(function(){

    	$(".modal-holiday").modal('toggle');
    });
    

    var _table = $('#dataTable').DataTable({
        "order": [[0, "desc"]]
    });

    setDraft();
    </script>

</body>
</html>
