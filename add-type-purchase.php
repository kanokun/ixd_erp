<?php
include_once('header.php');
include_once('nav.php');

$table = "type_purchase";

// 매입 품목 리스트
$stmt = $dbh->prepare("SELECT * FROM $table ORDER BY name DESC");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">매입 품목 추가</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-building-o"></i> 매입 품목 입력 폼</div>
        <div class="card-body">
			<form id="form-add" action="db-modify-row.php" method="post" target="ifr-hidden" >
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="db_type" value="insert">
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-12">
                    <label for="input-name" class="label-need">품목 명</label>
                     <input class="form-control" id="input-name" name="name" type="text" placeholder="품목 명">
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
          <i class="fa fa-table"></i> 거래처 리스트</div>
        <div class="card-body">
          <div class="table-responsive">
          	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>품목 명</th>
                  <th>기타</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>품목 명</th>
                  <th>기타</th>
                </tr>
              </tfoot>
              <tbody>
              <?php
              foreach($list as $row){
              ?>
              	<tr>
              		<td class="td-btn"><?=$row['name']?><a class="btn btn-sm btn-primary btn-name-info" id="btn-info-<?=$row['id']?>" >+</a></td>
              		<td>
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
        <div class="card-footer small text-muted">나는 술이 먹고싶다.</div>
      </div>
    </div>
    
    
    
    <div class="modal fade modal-company-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form-modify" action="db-modify-row.php" method="post" target="ifr-hidden" >
    				<input type="hidden" name="table" value="<?=$table?>">
    				<input type="hidden" id="input2-type" name="db_type" value="update">
    				<input type="hidden" id="input2-id" name="id" value="">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input-name" class="label-need">품목 명</label>
                         <input class="form-control input2" id="input2-name" name="name" type="text" placeholder="품목 명">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input-etc">비고</label>
                        <textarea class="form-control" id="input2-etc" name="etc" placeholder="비고" ></textarea>
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

    	var name = $("#input-name").val();

    	if(name.trim().length == 0) {
        	alert("품목 명을 입력해주세요.");
        	return;
    	}

		$("#form-add").submit();
    });

    $("#btn-modify").click(function(){

    	var name = $("#input2-name").val();

    	if(name.trim().length == 0) {
        	alert("품목 명을 입력해주세요.");
        	return;
    	}

		$("#form-modify").submit();
    });

    $(".btn-name-info").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM <?=$table?> WHERE `id`=" + id + " limit 1"
        }).done(function(data) {

        	$(".input2").attr("readonly", true);
        	$("#input2-etc").attr("readonly", "readonly");
        	
        	$("#input2-name").val(data[0].name);
        	$("#input2-etc").val(data[0].etc);

        	$("#btn-modify").css('display','none');
        	
        	$(".modal-company-info").modal();
        });
    });

    $(".btn-modify").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $("#input2-id").val(id);

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM <?=$table?> WHERE `id`=" + id + " limit 1"
        }).done(function(data) {

        	$(".input2").attr("readonly", false);
        	$("#input2-etc").removeAttr("readonly");
        	
        	$("#input2-name").val(data[0].name);
        	$("#input2-etc").val(data[0].etc);

        	$("#btn-modify").css('display','block');
        	
        	$(".modal-company-info").modal();
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
