<?php
include_once('header.php');
include_once('nav.php');

$table = "account";

$stmt = $dbh->prepare("SELECT * FROM $table WHERE `id`=".$_SESSION['id']." LIMIT 1");

$stmt->execute();
$list = $stmt->fetchAll();

$name = '';
$nick = '';
$email = '';
$phone = '';
$phone_inside = '';
$position = '';
$holiday = 0;
$etc = '';
$img = './img/noname.png';

foreach($list as $row){
    $name = $row['name'];
    $nick = $row['nick'];
    $email = $row['email'];
    $phone = $row['phone'];
    $phone_inside = $row['phone_inside'];
    $position = $row['position'];
    $holiday = $row['holiday'];
    $etc = $row['etc'];
    
    if($row['img'] != '')
        $img = './img/uploads/'.$row['id'].'/'.$row['img'];
}
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">내 정보</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-user"></i> 내 정보
          <div class="card-toggle" ><i class="fa fa-chevron-up" aria-hidden="true" ></i></div>
        </div>
        
        <div class="card-body">
        	<div class="container-info col-lg-12">
        		<img class="container-info-img" src="<?=$img?>" title="수정">
        	</div>
        	<div class="container-info col-lg-6">
        		이름 : <?=$name?>
        	</div>
        	<div class="container-info col-lg-6">
        		직급 : <?=$position?>
        	</div>
        	<div class="container-info col-lg-6">
        		아이디 : <?=$nick?>
        	</div>
        	<div class="container-info col-lg-6">
        		이메일 : <?=$email?>
        	</div>
        	<div class="container-info col-lg-6">
        		핸드폰 : <?=$phone?>
        	</div>
        	<div class="container-info col-lg-6">
        		내선번호 : <?=$phone_inside?>
        	</div>
        	<div class="container-info col-lg-6">
        		휴가일수 : <?=$holiday?> 일
        	</div>
        	<div class="container-info col-lg-12">
        		비고 : <?=$etc?>
        	</div>
        </div>
        
        <div class="card-footer small text-muted">
        	나는 탕수육이 먹고싶다.
        </div>
      </div>
    </div>
    
    
    <div class="modal fade modal-img-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form_img" enctype="multipart/form-data" action="modify-img.php" target="ifr-hidden" method="post">
    				<input type="hidden" id="input2-id" name="id" value="<?=$_SESSION['id']?>">
                    <div class="form-group">
                        <div class="form-row">
                          <div class="col-md-12">
                            <label for="input2-img" class="label-need">프로필 이미지 ( 50 x 50 권장 )</label>
                             <input class="form-control input2" id="input2-img" name="img" type="file" >
                          </div>
                        </div>
                    </div>
					<a class="btn btn-primary btn-block" id="btn-modify" >수정</a>
				</form>
			</div>
		</div>
    </div>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

<?php include_once('footer.php') ?>

<script>
$(".container-info-img").click(function() {
	$(".modal-img-info").modal();
});

$("#btn-modify").click(function() {

	if($("#input2-img").val() == '')
	{
		alert("이미지를 선택해주세요.");
		return;
	}
	
	$("#form_img").submit();
});
</script>