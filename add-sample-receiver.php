<?php
include_once('header.php');
include_once('nav.php');

$table = "sample_receiver";


// 무료구독자  리스트
$stmt = $dbh->prepare("SELECT A.*, B.name FROM $table A, account B WHERE A.id_sender=B.id ORDER BY A.date DESC");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT * FROM account WHERE level != 100 ORDER BY level DESC");
$stmt->execute();
$list_acc = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">무료 구독자 관리</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-building-o"></i> 무료 구독자 추가 폼</div>
        <div class="card-body">
			<form id="form-add" action="db-modify-row.php" method="post" target="ifr-hidden" >
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="db_type" value="insert">

              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="input-sender" >담당자</label>
                    <select class="form-control" id="input-sender" name="id_sender">
					<?php
					foreach($list_acc as $row){
                    ?>
                    	<option value=<?=$row['id']?>><?=$row['name']?></option>
                    <?php
                    }
                    ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="label-need" for="input-receiver">수신처</label>
                    <input type="text" class="form-control" id="input-receiver" name="receiver" placeholder="샘플 수신처">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                	<div class="col-md-12">
                        <label class="label-need" for="input-addr">주소</label>
                        <input type="text" class="form-control" id="input-addr" name="addr" placeholder="주소">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                      <label class="label-need" for="input-phone">연락처</label>
                      <input class="form-control" id="input-phone" name="phone" type="text" placeholder="연락처">
                  </div>
                  <div class="col-md-6">
                    <label class="label-need" for="input-ixd">IXD 권수</label>
                    <input class="form-control" id="input-ixd" name="ixd" type="text" value=0 >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                      <label class="label-need" for="input-deco">데코 권수</label>
                      <input class="form-control" id="input-deco" name="deco" type="text" value=0>
                  </div>
                  <div class="col-md-6">
                    <label class="label-need" for="input-jurak">주락 권수</label>
                    <input class="form-control" id="input-jurak" name="jurak" type="text" value=0 >
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
          <i class="fa fa-table"></i> 무료 구독자 리스트</div>
        <div class="card-body">
          <div class="table-responsive">
          	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>담당자</th>
                  <th>수신처</th>
                  <th>IXD</th>
                  <th>데코</th>
                  <th>주락</th>
                  <th>기타</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($list as $row){
              ?>
              	<tr>
              		<td><?=$row['name']?></td>
              		<td><?=$row['receiver']?></td>
              		<td><?=$row['ixd']?></td>
              		<td><?=$row['deco']?></td>
              		<td><?=$row['jurak']?></td>
              		<td>
              			<a class="btn btn-sm btn-primary btn-subscr-info" id="btn-subscr-info-<?=$row['id']?>" >+</a>
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
    
    
    <div class="modal fade modal-subscr-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form-modify" action="db-modify-row.php" method="post" target="ifr-hidden" >
					<input type="hidden" name="table" value="<?=$table?>">
    				<input type="hidden" id="input1-id" name="id" value="">
					<input type="hidden" name="db_type" value="update">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="input-sender" >담당자</label>
                        <select class="form-control input1" id="input1-sender" name="id_sender" >
    					<?php
    					foreach($list_acc as $row){
                        ?>
                        	<option value=<?=$row['id']?>><?=$row['name']?></option>
                        <?php
                        }
                        ?>
                        </select>
                      </div>
    
                      <div class="col-md-6">
                        <label class="label-need" for="input-receiver">수신처</label>
                        <input type="text" class="form-control input1" id="input1-receiver" name="receiver" placeholder="샘플 수신처">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                    	<div class="col-md-12">
                            <label class="label-need" for="input-addr">주소</label>
                            <input type="text" class="form-control input1" id="input1-addr" name="addr" placeholder="주소">
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                          <label class="label-need" for="input-phone">연락처</label>
                          <input class="form-control input1" id="input1-phone" name="phone" type="text" placeholder="연락처">
                      </div>
                      <div class="col-md-6">
                        <label class="label-need" for="input1-ixd">IXD 권수</label>
                        <input class="form-control input1" id="input1-ixd" name="ixd" type="text" value=0 >
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                          <label class="label-need" for="input1-deco">데코 권수</label>
                          <input class="form-control input1" id="input1-deco" name="deco" type="text" value=0>
                      </div>
                      <div class="col-md-6">
                        <label class="label-need" for="input1-jurak">주락 권수</label>
                        <input class="form-control input1" id="input1-jurak" name="jurak" type="text" value=0 >
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input-etc">비고</label>
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

    	var receiver = $("#input-receiver").val();
    	var addr = $("#input-addr").val();
    	var phone = $("#input-phone").val();

    	if(receiver.trim().length == 0) {
        	alert("수신처를 입력해주세요.");
        	return;
    	}
    	if(addr.trim().length == 0) {
        	alert("주소를 입력해주세요.");
        	return;
    	}
    	if(phone.trim().length == 0) {
        	alert("연락처를 입력해주세요.");
        	return;
    	}

		$("#form-add").submit();
    });

    $("#btn-modify").click(function(){

    	var receiver = $("#input1-receiver").val();
    	var addr = $("#input1-addr").val();
    	var phone = $("#input1-phone").val();

    	if(receiver.trim().length == 0) {
        	alert("수신처를 입력해주세요.");
        	return;
    	}
    	if(addr.trim().length == 0) {
        	alert("주소를 입력해주세요.");
        	return;
    	}
    	if(phone.trim().length == 0) {
        	alert("연락처를 입력해주세요.");
        	return;
    	}

		$("#form-modify").submit();
    });

    $(".btn-subscr-info").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];


        "SELECT A.*, B.name FROM $table A, account B WHERE A.id_sender=B.id ORDER BY A.date DESC"

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM <?=$table?> WHERE id=" + id + " limit 1"
        }).done(function(data) {

        	$(".input1").attr("readonly", true);
        	$("#input1-etc").attr("readonly", "readonly");

        	$("#input1-sender").val(data[0].id_sender).prop("selected", true);
        	$("#input1-receiver").val(data[0].receiver);
        	$("#input1-addr").val(data[0].addr);
        	$("#input1-phone").val(data[0].phone);
        	$("#input1-ixd").val(data[0].ixd);
        	$("#input1-deco").val(data[0].deco);
        	$("#input1-jurak").val(data[0].jurak);
        	$("#input1-etc").val(data[0].etc);

        	$("#btn-modify").css('display','none');
        	
        	$(".modal-subscr-info").modal();
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
        	
        	$("#input1-sender").val(data[0].id_sender).prop("selected", true);
        	$("#input1-receiver").val(data[0].receiver);
        	$("#input1-addr").val(data[0].addr);
        	$("#input1-phone").val(data[0].phone);
        	$("#input1-ixd").val(data[0].ixd);
        	$("#input1-deco").val(data[0].deco);
        	$("#input1-jurak").val(data[0].jurak);
        	$("#input1-etc").val(data[0].etc);

        	$("#btn-modify").css('display','block');
        	
        	$(".modal-subscr-info").modal();
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

	var _table = $('#dataTable').DataTable({
        "order": [[0, "asc"]]
    });
    </script>

</body>
</html>