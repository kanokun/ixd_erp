<?php
include_once('header.php');
include_once('nav.php');

$table = "magazine";

// 잡지판매현황 리스트
$stmt = $dbh->prepare("SELECT * FROM $table ORDER BY date DESC");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">잡지 판매현황</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-book"></i> 잡지 판매현황 폼</div>
        <div class="card-body">
			<form id="form-add" action="db-modify-row.php" method="post" target="ifr-hidden" >
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="db_type" value="insert">
								
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                      <label for="input-type">잡지종류</label>
                      <select class="form-control" id="input-type" name="type">
                      	<option value="ixd">ixd</option>
                      	<option value="데코">데코</option>
                      	<option value="주락">주락</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                    <label class="label-need" for="input-month">해당 월</label>
                    <input class="form-control" id="input-month" name="month" type="text" data-toggle="datepicker">
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-6">
                      <label for="input-count-call">전화</label>
                      <input class="form-control" id="input-count-call" name="count-call" type="text" value=0 numberOnly>
                    </div>
                	<div class="col-md-6">
                      <label for="input-count-homepage">홈페이지</label>
                      <input class="form-control" id="input-count-homepage" name="count-homepage" type="text" value=0 numberOnly>
                    </div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-6">
                      <label for="input-count-themagazine">더매거진</label>
                      <input class="form-control" id="input-count-themagazine" name="count-themagazine" type="text" value=0 numberOnly>
                    </div>
                	<div class="col-md-6">
                      <label for="input-count-unit">낱권</label>
					  <input class="form-control" id="input-count-unit" name="count-unit" type="text" value=0 numberOnly>
                    </div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-6">
                      <label for="input-count-exhibit">전시</label>
                      <input class="form-control" id="input-count-exhibit" name="count-exhibit" type="text" value=0 numberOnly>
                    </div>
                	<div class="col-md-6">
                      <label for="input-count-etc">지인·기타</label>
					  <input class="form-control" id="input-count-etc" name="count-etc" type="text" value=0 numberOnly>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-6">
                      <label for="input-count-finish">구독만료</label>
					  <input class="form-control" id="input-count-finish" name="count-finish" type="text" value=0 numberOnly>
                    </div>
                    <div class="col-md-6">
                      <label for="input-count-resubscr">재구독자</label>
                      <input class="form-control" id="input-count-resubscr" name="count-resubscr" type="text" value=0 numberOnly>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-6">
                      <label for="input-count-subscr">총 구독자</label>
                      <input class="form-control" id="input-count-subscr" name="count-subscr" type="text" value=0 numberOnly>
                    </div>
                	<div class="col-md-6">
                      <label for="input-count-all">총 판매수</label>
					  <input class="form-control" id="input-count-all" name="count-all" type="text" value=0 readonly numberOnly>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-12">
                    <label for="input-etc">비고</label>
                    <textarea class="form-control" id="input-etc" name="etc" placeholder="비고" ></textarea>
                  </div>
                </div>
              </div>
              <a class="btn btn-primary btn-block" id="btn-add" >추가</a>
          </form>
        </div>
      </div>


      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 잡지 판매현황 리스트</div>
        <div class="card-body">
          <div class="table-responsive">
          	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>잡지종류</th>
                  <th>해당 월</th>
                  <th>총 구독자</th>
                  <th>낱권</th>
                  <th>총 판매수</th>
                  <th>기타</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($list as $row){
                  
                  $month = substr($month, 0, 4) + substr($month, 4, 2);
              ?>
              	<tr>
              		<td><?=$row['type']?></td>
              		<td><?=$row['month']?></td>
              		<td><?=$row['count_subscr']?></td>
              		<td><?=$row['count_unit']?></td>
              		<td><?=$row['count_all']?></td>
              		<td>
              			<a class="btn btn-sm btn-primary btn-sales-info" id="btn-sales-info-<?=$row['id']?>" >+</a>
              			<a class="btn btn-sm btn-primary btn-modify" id="btn-modify-<?=$row['id']?>" >편집</a>
              			<a class="btn btn-sm btn-primary btn-delete" id="btn-delete-<?=$row['id']?>" >삭제</a>
              		</td>
              	</tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">두유가 혼자서 산책을 하면 좋겠다.</div>
      </div>
    </div>
    
    <div class="modal fade modal-sales-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form-modify" action="db-modify-row.php" method="post" target="ifr-hidden" >
					<input type="hidden" name="table" value="<?=$table?>">
    				<input type="hidden" id="input1-id" name="id" value="">
					<input type="hidden" name="db_type" value="update">
					
					
					<div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                          <label for="input1-type">잡지종류</label>
                          <select class="form-control input1" id="input1-type" name="type">
                          	<option value="ixd">ixd</option>
                          	<option value="데코">데코</option>
                          	<option value="주락">주락</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                        <label class="label-need" for="input1-month">해당 월</label>
                        <input class="form-control input1" id="input1-month" name="month" type="text" data-toggle="datepicker">
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-6">
                          <label for="input1-count-call">전화</label>
                          <input class="form-control input1" id="input1-count-call" name="count-call" type="text" value=0 numberOnly>
                        </div>
                    	<div class="col-md-6">
                          <label for="input1-count-homepage">홈페이지</label>
                          <input class="form-control input1" id="input1-count-homepage" name="count-homepage" type="text" value=0 numberOnly>
                        </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-6">
                          <label for="input1-count-themagazine">더매거진</label>
                          <input class="form-control input1" id="input1-count-themagazine" name="count-themagazine" type="text" value=0 numberOnly>
                        </div>
                    	<div class="col-md-6">
                          <label for="input1-count-unit">낱권</label>
    					  <input class="form-control input1" id="input1-count-unit" name="count-unit" type="text" value=0 numberOnly>
                        </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-6">
                          <label for="input1-count-exhibit">전시</label>
                          <input class="form-control input1" id="input1-count-exhibit" name="count-exhibit" type="text" value=0 numberOnly>
                        </div>
                    	<div class="col-md-6">
                          <label for="input1-count-etc">지인·기타</label>
    					  <input class="form-control input1" id="input1-count-etc" name="count-etc" type="text" value=0 numberOnly>
                        </div>
                    </div>
                  </div>
    
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-6">
                          <label for="input1-count-finish">구독만료</label>
    					  <input class="form-control input1" id="input1-count-finish" name="count-finish" type="text" value=0 numberOnly>
                        </div>
                        <div class="col-md-6">
                          <label for="input1-count-resubscr">재구독자</label>
                          <input class="form-control input1" id="input1-count-resubscr" name="count-resubscr" type="text" value=0 numberOnly>
                        </div>
                    </div>
                  </div>
    
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-6">
                          <label for="input1-count-subscr">총 구독자</label>
                          <input class="form-control input1" id="input1-count-subscr" name="count-subscr" type="text" value=0 numberOnly>
                        </div>
                    	<div class="col-md-6">
                          <label for="input1-count-all">총 판매수</label>
    					  <input class="form-control input1" id="input1-count-all" name="count-all" type="text" value=0 readonly numberOnly>
                        </div>
                    </div>
                  </div>
    
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input1-etc">비고</label>
                        <textarea class="form-control" id="input1-etc" name="etc" placeholder="비고" ></textarea>
                      </div>
                    </div>
                  </div>

                  <a class="btn btn-primary btn-block" id="btn-modify" >수정</a>
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


<?php include_once('footer.php') ?>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script>
    $("#btn-add").click(function(){

        if($("#input-month").val() == "")
        {
            alert("해당 월을 지정해주세요.");
            return;
        }

        $("#input-month").val($("#input-month").val().replace("/",""));

        if($("#input-count-call").val() == "")
        	$("#input-count-call").val(0);

        if($("#input-count-homepage").val() == "")
        	$("#input-count-homepage").val(0);

        if($("#input-count-themagazine").val() == "")
        	$("#input-count-themagazine").val(0);

        if($("#input-count-unit").val() == "")
        	$("#input-count-unit").val(0);

        if($("#input-count-exhibit").val() == "")
        	$("#input-count-exhibit").val(0);

        if($("#input-count-etc").val() == "")
        	$("#input-count-etc").val(0);

        if($("#input-count-finish").val() == "")
        	$("#input-count-finish").val(0);

        if($("#input-count-resubscr").val() == "")
        	$("#input-count-resubscr").val(0);

        if($("#input-count-subscr").val() == "")
        	$("#input-count-subscr").val(0);

        if($("#input-count-all").val() == "")
        	$("#input-count-all").val(0);

		$("#form-add").submit();
    });

    
    $("#btn-modify").click(function(){

    	if($("#input1-month").val() == "")
        {
            alert("해당 월을 지정해주세요.");
            return;
        }

    	$("#input1-month").val($("#input1-month").val().replace("/",""));

        if($("#input1-count-call").val() == "")
        	$("#input1-count-call").val(0);

        if($("#input1-count-homepage").val() == "")
        	$("#input1-count-homepage").val(0);

        if($("#input1-count-themagazine").val() == "")
        	$("#input1-count-themagazine").val(0);

        if($("#input1-count-unit").val() == "")
        	$("#input1-count-unit").val(0);

        if($("#input1-count-exhibit").val() == "")
        	$("#input1-count-exhibit").val(0);

        if($("#input1-count-etc").val() == "")
        	$("#input1-count-etc").val(0);

        if($("#input1-count-finish").val() == "")
        	$("#input1-count-finish").val(0);

        if($("#input1-count-resubscr").val() == "")
        	$("#input1-count-resubscr").val(0);

        if($("#input1-count-subscr").val() == "")
        	$("#input1-count-subscr").val(0);

        if($("#input1-count-all").val() == "")
        	$("#input1-count-all").val(0);
    	
    	
		$("#form-modify").submit();
    });



    $(".btn-sales-info").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM <?=$table?> WHERE `id`=" + id + " limit 1"
        }).done(function(data) {

        	$(".input1").attr("readonly", true);
        	$("#input1-etc").attr("readonly", "readonly");

        	$("#input1-type").val(data[0].type).prop("selected", true);
        	$("#input1-month").val(data[0].month);
        	$("#input1-count-call").val(data[0].count_call);
        	$("#input1-count-homepage").val(data[0].count_homepage);
        	$("#input1-count-themagazine").val(data[0].count_themagazine);
        	$("#input1-count-unit").val(data[0].count_unit);
        	$("#input1-count-exhibit").val(data[0].count_exhibit);
        	$("#input1-count-etc").val(data[0].count_etc);
        	$("#input1-count-finish").val(data[0].count_finish);
        	$("#input1-count-resubscr").val(data[0].count_resubscr);
        	$("#input1-count-subscr").val(data[0].count_subscr);
        	$("#input1-count-all").val(data[0].count_all);
        	$("#input1-etc").val(data[0].etc);

        	$("#btn-modify").css('display','none');

        	$(".modal-sales-info").modal();
        });
    });

    $(".btn-modify").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $("#input1-id").val(id);

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM <?=$table?> WHERE `id`=" + id + " limit 1"
        }).done(function(data) {

        	$(".input1").attr("readonly", false);
        	$("#input1-count-all").attr("readonly", true);
        	$("#input1-etc").removeAttr("readonly");

        	$("#input1-type").val(data[0].type).prop("selected", true);
        	$("#input1-month").val(data[0].month);
        	$("#input1-count-call").val(data[0].count_call);
        	$("#input1-count-homepage").val(data[0].count_homepage);
        	$("#input1-count-themagazine").val(data[0].count_themagazine);
        	$("#input1-count-unit").val(data[0].count_unit);
        	$("#input1-count-exhibit").val(data[0].count_exhibit);
        	$("#input1-count-etc").val(data[0].count_etc);
        	$("#input1-count-finish").val(data[0].count_finish);
        	$("#input1-count-resubscr").val(data[0].count_resubscr);
        	$("#input1-count-subscr").val(data[0].count_subscr);
        	$("#input1-count-all").val(data[0].count_all);
        	$("#input1-etc").val(data[0].etc);

        	$("#btn-modify").css('display','block');
        	
        	$(".modal-sales-info").modal();
        });
    });


    $(".btn-delete").click(function() {

        var r = confirm("정말 삭제하시겠습니까?");
        
        if(!r){
            return;
        }else{
        	var id = $(this).attr('id').split('-');
            id = id[id.length-1];

            $.post( "db-modify-row.php", { db_type: "delete", table: "<?=$table?>", id:id }, function() {
                reload();
            });
        }
    });


    $('[data-toggle="datepicker"]').datepicker({
    	monthNamesShort: [ "01", "02", "03", "04","05", "06", "07", "08", "09","10", "11", "12" ],
    	changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        showMonthAfterYear: true,
        dateFormat: 'yy/mm',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });

    $("#input-count-unit").focusout(function (){

    	if($(this).val() == "")
        	$(this).val(0);

    	if($("#input-count-subscr").val() == "")
        	$("#input-count-subscr").val(0);

    	var sum = ($(this).val() * 1) + ($("#input-count-subscr").val() * 1);
    	
    	$("#input-count-all").val(sum);
    });

    $("#input-count-subscr").focusout(function (){
        
    	if($(this).val() == "")
        	$(this).val(0);

    	if($("#input-count-unit").val() == "")
        	$("#input-count-unit").val(0);

    	var sum = ($(this).val() * 1) + ($("#input-count-unit").val() * 1);
    	
    	$("#input-count-all").val(sum);
    });

    $("#input1-count-unit").focusout(function (){

    	if($(this).val() == "")
        	$(this).val(0);

    	if($("#input1-count-subscr").val() == "")
        	$("#input1-count-subscr").val(0);

    	var sum = ($(this).val() * 1) + ($("#input1-count-subscr").val() * 1);
    	
    	$("#input1-count-all").val(sum);
    });

    $("#input1-count-subscr").focusout(function (){
        
    	if($(this).val() == "")
        	$(this).val(0);

    	if($("#input1-count-unit").val() == "")
        	$("#input1-count-unit").val(0);

    	var sum = ($(this).val() * 1) + ($("#input1-count-unit").val() * 1);
    	
    	$("#input1-count-all").val(sum);
    });

	var _table = $('#dataTable').DataTable({
        "order": [[1, "desc"]]
    });
    </script>

</body>
</html>