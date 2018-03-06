<?php
include_once('header.php');
include_once('nav.php');

$table = "draft";

$stmt = $dbh->prepare("SELECT A.*, B.name FROM $table A, account B WHERE A.id_acc = B.id AND A.id=".$_POST['idx']." LIMIT 1");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


$id = 0;
$title = '';
$html = '';
$name = '';
$files = [];
$level = null;
$etc = '';

foreach($list as $row){

    $id = $row['id'];
    $name = $row['name'];
    $title = $row['title'];
    $html = $row['html'];
    $level = $row['level'];
    $etc = $row['etc'];

    if($row['files'] != ''){

        $files = explode("|",$row['files']);
    }
}
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb hide-print">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">기안서 보기</li>
      </ol>
      <!-- Example DataTables Card-->

      <div class="card mb-3">
        <div class="card-header hide-print">
          <i class="fa fa-file-text-o"></i> 기안서
        </div>

        <div class="card-body draft-body">
        	<div class="draft-btn hide-print">
        		<a class="btn btn-sm btn-primary" href="./draft-list.php">목록</a>
        		<a class="btn btn-sm btn-primary btn-print">인쇄</a>
        		
        		<?php
        		if($_SESSION['level'] >= 11){
        		    
        		    if(($level == 0 && $_SESSION['id'] == 11) || ($level == 1 && $_SESSION['id'] == 13) || ($level == 2 && $_SESSION['id'] == 12) || $_SESSION['id'] == 1 ){
        		?>
            		<a class="btn btn-sm btn-primary btn-reject">기각</a>
            		<a class="btn btn-sm btn-primary btn-allow">결재</a>
        		<?php
        		    }
        		}
        		?>
        	</div>
			<?=$html?>
			<br>
			<?php
			if($files[0] != ''){
			?>
			 - 첨부파일<br>
			<?php
			}

        	for($i=0; $i<sizeof($files); $i++) {
        	?>
        	    <a target="_blank" href="./file/uploads/<?=$id?>/<?=$files[$i]?>"><?=$files[$i]?></a><br>
        	<?php
        	}
        	?>

        	<div>
        		<?php
    			if($etc != ''){
    			?>
    			 <br>- 기각사유<br>
    			<?php
    			}
    			?>
        		<?=$etc?>
        	</div>
        </div>
        <div class="card-footer small text-muted hide-print">재가를 재가하여 재가해 주시기 재가 바랍니다.</div>
      </div>
    </div>


    <div class="modal fade modal-draft" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form-draft" action="./db-modify-draft.php" method="post" target="ifr-hidden">
    				<input type="hidden" id="input-id" name="id" value="<?=$id?>">
    				<input type="hidden" name="table" value="draft">
    				<input type="hidden" name="db_type" value="update">
    				<input type="hidden" id="input-type" name="type" value="">
    				<input type="hidden" id="input-level" name="level" value=<?=$level?>>
    				
                  	<div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input-etc">기각 사유를 적어주세요.</label>
                        <textarea class="form-control" id="input-etc" name="etc" placeholder="사유" ></textarea>
                        
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
    $(".draft-sign-level0").html("<?=$name?>");

    <?php
    if($level > 0)
    {
        echo '$(".draft-sign-level1").html("박미정");';
        
        if($level > 1) {
            echo '$(".draft-sign-level2").html("최문형");';
            
            if($level == 10) {
                echo '$(".draft-sign-level3").html("박미경");';
            }
        }
    }else {
        
        if($level == -1) {
            echo '$(".draft-sign-level1").html(\'<span style="color:red;">기각</span>\');';
        }else if($level == -2) {
            //echo '$(".draft-sign-level1").html("박미정");';
            echo '$(".draft-sign-level2").html(\'<span style="color:red;">기각</span>\');';
        }else if($level == -3) {
            //echo '$(".draft-sign-level1").html("박미정");';
            echo '$(".draft-sign-level2").html("최문형");';
            echo '$(".draft-sign-level3").html(\'<span style="color:red;">기각</span>\');';
        }
    }
    ?>

    $(".btn-print").click(function(){
        window.print();
    });

    $(".btn-allow").click(function(){

        if(confirm("결재 하시겠습니까?")){

        	$("#input-etc").val('');
        	$("#input-type").val("draft");
        	$("#form-draft").submit();
        }
    });

    $(".btn-reject").click(function(){
        
    	$(".modal-draft").modal();
    });

    $(".btn-ok").click(function(){

    	$("#input-type").val("reject");
        $("#form-draft").submit();
    });

    $(".btn-cancel").click(function(){

    	$(".modal-draft").modal('toggle');
    });
    </script>

</body>
</html>
