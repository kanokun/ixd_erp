<?php
include_once('header.php');
include_once('nav.php');

$table = "account";

// 자회사 리스트
$stmt = $dbh->prepare("SELECT * FROM $table WHERE level <= 10 ORDER BY name ASC");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">휴가 주기</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-bicycle" aria-hidden="true"></i> 휴가 주기</div>
        <div class="card-body">
			<form id="form-add" action="db-modify-holiday.php" method="post" target="ifr-hidden" >
				<input type="hidden" name="table" value="holiday">
				<input type="hidden" name="db_type" value="insert">

              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                      <label for="input-id-acc" class="label-need">대상</label>
                      <select class="form-control" id="input-id-acc" name="id_acc">
                      	  <option value=0>전원</option>
        				  <?php
                          foreach($list as $row){
                          ?>
                       	  <option value=<?=$row['id']?>><?=($row['name']." ".$row['position'])?></option>
                          <?php
                          }
                          ?>
                      </select>
                  </div>
                  <div class="col-md-6">
                    <label for="input-count" class="label-need">일 수</label>
                    <input class="form-control" id="input-count" name="count" type="text" placeholder="일 수" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="input-etc" class="label-need">사유</label>
                    <input class="form-control" id="input-etc" name="etc" type="text" placeholder="사유">
                  </div>
                </div>
              </div>

              <a class="btn btn-primary btn-block" id="btn-add" >추가</a>
          </form>
        </div>
      </div>
      
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 직원별 휴가 현황</div>
        <div class="card-body">
          <div class="table-responsive">
          	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>이름</th>
                  <th>직급</th>
                  <th>이메일</th>
                  <th>전화번호</th>
                  <th>내선번호</th>
                  <th>남은 휴가일</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($list as $row){
              ?>
              	<tr>
              		<td id="holiday-name-<?=$row['id']?>"><?=$row['name']?></td>
              		<td id="holiday-position-<?=$row['id']?>"><?=$row['position']?></td>
              		<td><?=$row['email']?></td>
              		<td><?=$row['phone']?></td>
              		<td><?=$row['phone_inside']?></td>
              		<td class="td-btn"><?=$row['holiday']?><a class="btn btn-sm btn-primary btn-history" id="btn-history-<?=$row['id']?>" >내역</a></td>
              	</tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">아무도 나의 휴가를 막을 순 없지.</div>
      </div>
    </div>
    
    <div class="modal fade modal-holiday-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="holiday-history-title">
					<i class="fa fa-bicycle" aria-hidden="true"></i> <span class="holiday-title-name"></span>
				</div>
				<table>
					<thead>
    					<tr>
    						<th>날짜</th>
    						<th>사유</th>
    						<th>일수</th>
    					</tr>
					</thead>
					<tbody class="holiday-history"></tbody>
				</table>
			</div>
		</div>
    </div>

<?php include_once('footer.php') ?>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    
    <script>
    var _table = $('#dataTable').DataTable({
        "order": [[0, "asc"]]
    });

    $(".btn-history").click(function(){
        
    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM holiday WHERE `id_acc`=" + id + " ORDER BY date DESC"
        }).done(function(data) {

        	var _html = '';

        	if(data != null){
        		for(var i=0; i<data.length; i++)
            	{
                	_html += "<tr><td>" + data[i]['date_start'] + "</td>";
                	_html += "<td>" + data[i]['etc'] + "</td>";
                	_html += "<td>" + data[i]['count'] + "</td></tr>";
            	}
        	}

        	$(".holiday-title-name").html($("#holiday-name-"+id).html() + " " + $("#holiday-position-"+id).html() + " 휴가 내역");
        	$(".holiday-history").html(_html);
        	
        	$(".modal-holiday-info").modal();
        });
    });

    $("#btn-add").click(function() {

    	if($("#input-count").val().length == 0) {
        	alert("부여할 휴가 일 수를 적어주세요.");
        	return;
    	}

    	if($("#input-etc").val().length == 0) {
        	alert("부여할 휴가의 사유를 적어주세요.");
        	return;
    	}

    	$("#form-add").submit();
    });
    </script>

</body>
</html>