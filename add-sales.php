<?php
include_once('header.php');
include_once('nav.php');

$table = "sales";

// 매출 리스트
$stmt = $dbh->prepare("SELECT * FROM company_self ORDER BY name ASC");
$stmt->execute();
$company_self_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT * FROM company ORDER BY name ASC");
$stmt->execute();
$company_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT * FROM type_sales ORDER BY name ASC");
$stmt->execute();
$type_sales_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT A.*,B.name as company_self_name, C.name as company_name, D.name as type_name FROM sales A, company_self B, company C, type_sales D WHERE A.id_comp_self = B.id AND A.id_comp = C.id AND A.id_type = D.id ORDER BY date DESC");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($_list as $row){
    echo $row['company_slef_name'];
}
?>
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">매출 추가</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-building-o"></i> 매출 입력 폼</div>
        <div class="card-body">
			<form id="form-add" action="db-modify-row.php" method="post" target="ifr-hidden" >
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="db_type" value="insert">
				
				<!-- 
				<div class="form-group form-group-top">
                    <div class="form-row">
                        <div class="col-md-12 row-text-right">
                        	<label id="label-consignment" for="input-consignment" >위수탁</label>
                        	<input type="checkbox" id="input-consignment" name="consignment" >
                        </div>
                    </div>
                </div>
                 -->
				
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="input-company-self" class="label-need">회사 명</label> 
                    <select class="form-control" id="input-company-self" name="company_self">
					<?php
                    foreach($company_self_list as $row){
                    ?>
                    	<option value=<?=$row['id']?>><?=$row['name']?></option>
                    <?php
                    }
                    ?>
                    </select>
                  </div>
                  
                  <div class="col-md-6">
                    <label class="label-need" for="input-company">거래처 명</label>
                    <select class="form-control" id="input-company" name="company">
					<?php
                    foreach($company_list as $row){
                    ?>
                    	<option value=<?=$row['id']?>><?=$row['name']?></option>
                    <?php
                    }
                    ?>
                    </select>
                  </div>
                  
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                
                	<div class="col-md-6">
                        <label class="label-need" for="input-type">품목 명</label>
                        <select class="form-control" id="input-type" name="type">
    					<?php
    					foreach($type_sales_list as $row){
                        ?>
                        	<option value=<?=$row['id']?>><?=$row['name']?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                  
                  <div class="col-md-6">
                    <label for="input-detail">품목 상세</label>
                    <input class="form-control" id="input-detail" name="detail" type="text" placeholder="품목 상세">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                      <label for="input-cost-type">지불방법</label>
                      <select class="form-control" id="input-cost-type" name="cost-type">
                      	<option value="현금">현금</option>
                      	<option value="전자어음">전자어음</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                    <label class="label-need" for="input-cost">금액</label>
                    <input class="form-control" id="input-cost" name="cost" type="text" placeholder="금액" value=0 numberOnly>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-6">
                      <label for="input-tax">부가세</label>
                      <input class="form-control" id="input-tax" name="tax" type="text" placeholder="부가세" value=0 numberOnly>
                    </div>
                	<div class="col-md-6">
                      <label for="input-final-cost">총 금액</label>
                      <input class="form-control" id="input-final-cost" name="final-cost" type="text" placeholder="총 금액" value=0 readonly numberOnly>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="input-fax" class="label-need">날짜</label>
                    <input class="form-control" id="input-date" name="date" type="text" data-toggle="datepicker" >
                  </div>
                  <div class="col-md-6">
                      <label for="input-state">결제현황</label>
                      <select class="form-control" id="input-state" name="state">
                      	<option value="미등록">미등록</option>
                      	<option value="미납">미납</option>
                      	<option value="입금">입금</optin>
                      </select>
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
          <i class="fa fa-table"></i> 매출 리스트</div>
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
                  <th>금액</th>
                  <th>총금액</th>
                  <th>결제현황</th>
                  <th>기타</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($list as $row){
                  $_date = substr($row['date'],0,4).'/'.substr($row['date'],4,2).'/'.substr($row['date'],6);
              ?>
              	<tr>
              		<td><?=$_date?></td>
              		<td><?=$row['company_self_name']?></td>
              		<td class="td-btn"><?=$row['company_name']?><a class="btn btn-sm btn-primary btn-company-info" id="btn-company-info-<?=$row['id_comp']?>" >+</a></td>
              		<td class="td-btn"><?=$row['type_name']?><a class="btn btn-sm btn-primary btn-type-info" id="btn-type-info-<?=$row['id_type']?>" >+</a></td>
              		<td class="td-text-right"><?=number_format($row['cost'])?></td>
              		<td class="td-text-right"><?=number_format($row['cost'] + $row['tax'])?></td>
              		<td><?=$row['state']?></td>
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
    
    <div class="modal fade modal-type-sales-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        <label for="input1-company-self" class="label-need">회사 명</label> 
                        <select class="form-control input1" id="input1-company-self" name="company_self">
    					<?php
                        foreach($company_self_list as $row){
                        ?>
                        	<option value=<?=$row['id']?>><?=$row['name']?></option>
                        <?php
                        }
                        ?>
                        </select>
                      </div>
                      
                      <div class="col-md-6">
                        <label class="label-need" for="input1-company">거래처 명</label>
                        <select class="form-control input1" id="input1-company" name="company">
    					<?php
                        foreach($company_list as $row){
                        ?>
                        	<option value=<?=$row['id']?>><?=$row['name']?></option>
                        <?php
                        }
                        ?>
                        </select>
                      </div>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                    
                    	<div class="col-md-6">
                            <label class="label-need" for="input1-type">품목 명</label>
                            <select class="form-control input1" id="input1-type" name="type">
        					<?php
        					foreach($type_sales_list as $row){
                            ?>
                            	<option value=<?=$row['id']?>><?=$row['name']?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </div>
                      
                      <div class="col-md-6">
                        <label for="input1-detail">품목 상세</label>
                        <input class="form-control input1" id="input1-detail" name="detail" type="text" placeholder="품목 상세">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                          <label for="input1-cost-type">지불방법</label>
                          <select class="form-control input1" id="input1-cost-type" name="cost-type">
                          	<option value="현금">현금</option>
                          	<option value="전자어음">전자어음</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                        <label class="label-need" for="input1-cost">금액</label>
                        <input class="form-control input1" id="input1-cost" name="cost" type="text" placeholder="금액" value=0 numberOnly>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-6">
                            <label for="input1-tax">부가세</label>
                            <input class="form-control input1" id="input1-tax" name="tax" type="text" placeholder="부가세" value=0 numberOnly>
                        </div>
                    	<div class="col-md-6">
                          <label for="input1-final-cost">총 금액</label>
                          <input class="form-control input1" id="input1-final-cost" name="final-cost" type="text" placeholder="총 금액" value=0 readonly numberOnly>
                        </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                          <label for="input1-fax" class="label-need">날짜</label>
                          <input class="form-control input1" id="input1-date" name="date" type="text" data-toggle="datepicker" >
                        </div>
                        <div class="col-md-6">
                          <label for="input1-state">결제현황</label>
                          <select class="form-control input1" id="input1-state" name="state">
                          	<option value="미등록">미등록</option>
                      		<option value="미납">미납</option>
                      		<option value="입금">입금</optin>
                          </select>
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

<?php include_once('footer.php') ?>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script>
    $("#btn-add").click(function(){

    	var company_self = $("#input-company-self").val();
    	var company = $("#input-company").val();
    	var type = $("#input-type").val();
    	var cost = $("#input-cost").val();
    	var date = $("#input-date").val();

    	if(company_self.trim().length == 0) {
        	alert("먼저 자회사를 추가해주세요.");
        	return;
    	}
    	if(company.trim().length == 0) {
        	alert("먼저 거래처를 추가해주세요.");
        	return;
    	}
    	if(type.trim().length == 0) {
        	alert("먼저 매출 품목을 추가해주세요.");
        	return;
    	}
    	if(cost.trim().length == 0) {
        	alert("매출 금액을 입력해주세요.");
        	return;
    	}
    	if(date.trim().length == 0) {
        	alert("날짜를 선택해주세요.");
        	return;
    	}

		$("#form-add").submit();
    });

    $("#btn-modify").click(function(){

    	var company_self = $("#input1-company-self").val();
    	var company = $("#input1-company").val();
    	var type = $("#input1-type").val();
    	var cost = $("#input1-cost").val();
    	var date = $("#input1-date").val();

    	if(company_self.trim().length == 0) {
        	alert("먼저 자회사를 추가해주세요.");
        	return;
    	}
    	if(company.trim().length == 0) {
        	alert("먼저 거래처를 추가해주세요.");
        	return;
    	}
    	if(type.trim().length == 0) {
        	alert("먼저 매출 품목을 추가해주세요.");
        	return;
    	}
    	if(cost.trim().length == 0) {
        	alert("매출 금액을 입력해주세요.");
        	return;
    	}
    	if(date.trim().length == 0) {
        	alert("날짜를 선택해주세요.");
        	return;
    	}

		$("#form-modify").submit();
    });

    $(".btn-company-info").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM company WHERE `id`=" + id + " limit 1"
        }).done(function(data) {

            console.log(data);
        	
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

    $(".btn-type-info").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $("#input-id").val(id);

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM type_sales WHERE `id`=" + id + " limit 1"
        }).done(function(data) {
        	
        	$("#input3-name").val(data[0].name);
        	$("#input3-etc").val(data[0].etc);
        	
        	$(".modal-type-sales-info").modal();
        });
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
        	
        	$("#input1-company-self").val(data[0].id_comp_self).prop("selected", true);
        	$("#input1-company").val(data[0].id_comp).prop("selected", true);
        	$("#input1-type").val(data[0].id_type).prop("selected", true);
        	$("#input1-detail").val(data[0].type_detail);
        	$("#input1-cost").val(comma(data[0].cost));
        	$("#input1-tax").val(comma(data[0].tax));
        	$("#input1-final-cost").val(comma(data[0].cost*1 + data[0].tax*1));
        	$("#input1-date").val(data[0].date);
        	$("#input1-etc").val(data[0].etc);
        	$("#input1-cost-type").val(data[0].cost_type).prop("selected", true);
        	$("#input1-state").val(data[0].state).prop("selected", true);
        	
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
        	$("#input1-etc").removeAttr("readonly");
        	
        	$("#input1-company-self").val(data[0].id_comp_self).prop("selected", true);
        	$("#input1-company").val(data[0].id_comp).prop("selected", true);
        	$("#input1-type").val(data[0].id_type).prop("selected", true);
        	$("#input1-detail").val(data[0].type_detail);
        	$("#input1-cost").val(comma(data[0].cost));
        	$("#input1-tax").val(comma(data[0].tax));
        	$("#input1-final-cost").val(comma(data[0].cost*1 + data[0].tax*1));
        	$("#input1-date").val(data[0].date);
        	$("#input1-etc").val(data[0].etc);
        	$("#input1-cost-type").val(data[0].cost_type).prop("selected", true);
        	$("#input1-state").val(data[0].state).prop("selected", true);

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
    	changeMonth:true,
    	showMonthAfterYear: true,
        changeYear:true,
        dateFormat: "yy/mm/dd"
    });

    $("#input-cost").focusout(function (){

    	var cost = $(this).val();
    	var _cost = cost;
    	cost = cost.replace(',','');
    	cost /= 10;
    	cost = Math.floor(cost);
        
        $("#input-tax").val(comma(cost));
        cost = (cost * 1 + _cost * 1);
        $("#input-final-cost").val(comma(cost));
    });

    $("#input-tax").focusout(function (){
        
    	var cost = $("#input-cost").val();
    	var _cost = $(this).val();
    	cost = cost.replace(',','');
    	_cost = _cost.replace(',','');
    	cost = (cost * 1 + _cost * 1);
    	
    	$("#input-final-cost").val(comma(cost));
    });

    $("#input1-cost").focusout(function (){

    	var cost = $(this).val();
    	var _cost = cost;
    	cost = cost.replace(',','');
    	cost /= 10;
    	cost = Math.floor(cost);
        
        $("#input1-tax").val(comma(cost));
        cost = (cost * 1 + _cost * 1);
        $("#input1-final-cost").val(comma(cost));
    });

	$("#input1-tax").focusout(function (){
        
    	var cost = $("#input1-cost").val();
    	var _cost = $(this).val();
    	cost = cost.replace(',','');
    	_cost = _cost.replace(',','');
    	cost = (cost * 1 + _cost * 1);
    	
    	$("#input1-final-cost").val(comma(cost));
    });

	var _table = $('#dataTable').DataTable({
        "order": [[0, "desc"]]
    });
    </script>

</body>
</html>