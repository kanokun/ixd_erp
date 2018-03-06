<?php
include_once('header.php');
include_once('nav.php');

$table = "draft_holiday";

// 자회사 리스트
$query = "SELECT A.*, B.name FROM $table A, account B WHERE A.id_acc = B.id ";
if($_SESSION['level'] < 10)
    $query .= "AND A.id_acc = ". $_SESSION['id'] ." ";
$query .= "ORDER BY date DESC";

$stmt = $dbh->prepare($query);
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT holiday FROM account WHERE id_acc = ".$_SESSION['id']." LIMIT 1");
$stmt->execute();
$list_holiday = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count_final = 0;

foreach($list_holiday as $row){
    $count_final = $row['holiday'];
}
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">휴가 신청</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-bicycle" aria-hidden="true"></i> 휴가 신청 입력 폼</div>
        <div class="card-body">
			<form id="form-add" action="db-modify-row.php" method="post" target="ifr-hidden" >
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="db_type" value="insert">
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                      <label for="input-date-start" class="label-need">시작 일자</label>
                      <input class="form-control input" id="input-date-start" name="date-start" type="text" data-toggle="datepicker" >
                  </div>
                  <div class="col-md-6">
                      <label for="input-date-end" class="label-need">끝 일자</label>
                      <input class="form-control input" id="input-date-end" name="date-end" type="text" data-toggle="datepicker" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="input-count">일 수</label>
                    <input class="form-control" id="input-count" name="count" type="text" placeholder="일 수" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="input-fax">비고</label>
                    <input class="form-control" id="input-etc" name="etc" type="text" placeholder="ex) 월차, 병가, 대체휴가 등">
                  </div>
                </div>
              </div>

              <a class="btn btn-primary btn-block" id="btn-add" >추가</a>
          </form>
        </div>
      </div>
      
      
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 휴가 신청 현황</div>
        <div class="card-body">
          <div class="table-responsive">
          	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>신청인</th>
                  <th>날짜</th>
                  <th>휴가 일자</th>
                  <th>일 수</th>
                  <th>비고</th>
                  <th>상태</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($list as $row){
                  
                  $level = '';
                  
                  switch($row['level']) {
                      case 0:
                          $level = "과장님 승인 대기";
                          break;
                      case 1:
                          $level = "이사님 승인 대기";
                          break;
                      case 2:
                          $level = "대표님 승인 대기";
                          break;
                      case 10:
                          $level = "승인 완료";
                          break;
                  }
              ?>
              	<tr>
              		<td><?=$row['name']?></td>
              		<td><?=$row['date']?></td>
              		<td><?=$row['date_start']?></td>
              		<td><?=$row['count']?></td>
              		<td><?=$row['etc']?></td>
              		<td><?=$level?></td>
              		<!-- 
              		<td>
              			<a class="btn btn-sm btn-primary btn-modify" id="btn-modify-<?=$row['id']?>" >편집</a>
              			<a class="btn btn-sm btn-primary btn-delete" id="btn-delete-<?=$row['id']?>" >삭제</a>
              		</td>
              		-->
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
    

<?php include_once('footer.php') ?>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script>

    function calcDay() {

    	var start = $("#input-date-start").val();
        var end = $("#input-date-end").val();

        var arr1 = start.split('/');
        var arr2 = end.split('/');
        var dat1 = new Date(arr1[0], arr1[1], arr1[2]);
        var dat2 = new Date(arr2[0], arr2[1], arr2[2]);

        var diff = dat2 - dat1;
        var currDay = 24 * 60 * 60 * 1000;// 시 * 분 * 초 * 밀리세컨

        return parseInt(diff/currDay);
    }

    $("#input-date-start").change(function(){

        if($("#input-date-end").val() == '')
            $("#input-date-end").val($(this).val());

        $("#input-count").val(calcDay()+1);
    });

    $("#input-date-end").change(function(){

        $("#input-count").val(calcDay()+1);
    });
    
    $("#btn-add").click(function(){

    	if($("#input-date-start").val() == '') {
        	alert("시작 일자를 채워주세요.");
        	return;
    	}

    	if($("#input-date-end").val() == '') {
        	alert("끝 일자를 채워주세요.");
        	return;
    	}

    	if(parseInt($("#input-count").val()) > <?=$count_final?>) {
        	alert("남은 휴가 날짜가 모자랍니다.");
        	return;
    	}

		$("#form-add").submit();
    });

    var _table = $('#dataTable').DataTable({
        "order": [[0, "asc"]]
    });

    $('[data-toggle="datepicker"]').datepicker({
    	monthNamesShort: [ "01", "02", "03", "04","05", "06", "07", "08", "09","10", "11", "12" ],
    	changeMonth:true,
    	showMonthAfterYear: true,
        changeYear:true,
        dateFormat: "yy/mm/dd"
    });
    </script>

</body>
</html>