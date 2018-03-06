<?php
include_once('header.php');
include_once('nav.php');

$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$stmt = $dbh->prepare("SELECT A.*, B.name, B.position, B.img FROM board_mini A, account B WHERE A.id_acc = B.id ORDER BY A.id DESC LIMIT 10");
$stmt->execute();
$list = $stmt->fetchAll();

$stmt = $dbh->prepare("SELECT level FROM draft WHERE level != 10 AND id_acc = ".$_SESSION['id']);
$stmt->execute();
$list_draft = $stmt->fetchAll();

$draft_count = 0;

foreach($list_draft as $row){
    
    if($row['level'] > 0)
        $draft_count++;
}

$stmt = $dbh->prepare("SELECT count(id) FROM draft_holiday WHERE level != 10 AND id_acc = ".$_SESSION['id']);
$stmt->execute();
$list_draft_holiday = $stmt->fetchAll();

$draft_holiday_count = 0;

foreach($list_draft_holiday as $row){
    
    if($row['level'] > 0)
        $draft_holiday_count++;
}

if($_SESSION['id'] > 10 && $_SESSION['id'] < 14)
{
    $query = "SELECT count(id) FROM draft WHERE";

    switch($_SESSION['id']) {
        case 11:
            $query .= " level = 0";
            break;
        case 13:
            $query .= " level = 1";
            break;
        case 12:
            $query .= " level = 2";
            break;
    }
    
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $list_draft_permission = $stmt->fetchAll();
    
    $draft_permission_count = 0;
    
    foreach($list_draft_permission as $row){
        $draft_permission_count = $row['count(id)'];
    }
    
    
    $query = "SELECT count(id) FROM draft_holiday WHERE";
    
    switch($_SESSION['id']) {
        case 11:
            $query .= " level = 0";
            break;
        case 13:
            $query .= " level = 1";
            break;
        case 12:
            $query .= " level = 2";
            break;
    }
    
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $list_draft_holiday_permission = $stmt->fetchAll();
    
    $draft_holiday_permission_count = 0;
    
    foreach($list_draft_holiday_permission as $row){
        $draft_holiday_permission_count = $row['count(id)'];
    }
}

if($_SESSION['id'] == 11){
    
    $query = "SELECT count(id) FROM sales WHERE state='미등록'";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $list_sales_yet = $stmt->fetchAll();
    
    $sales_yet_count = 0;
    
    foreach($list_sales_yet as $row){
        $sales_yet_count = $row['count(id)'];
    }
}
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">홈</a>
        </li>
        <li class="breadcrumb-item active">대시보드</li>
      </ol>
      <!-- Icon Cards-->
      
      <div class="row">
      	<?php
      	if($draft_holiday_count > 0){
      	?>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden ">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <a class="text-white clearfix small z-1" href="add-holiday.php">
              	<div class="mr-5">대기 중인 내 휴가요청 : <?=$draft_holiday_count?>개</div>
              </a>
            </div>
          </div>
        </div>
        <?php
      	}

      	if($draft_count > 0){
        ?>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden ">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <a class="text-white clearfix small z-1" href="draft-list.php">
              	<div class="mr-5">대기 중인 내 기안 : <?=$draft_count?>개</div>
              </a>
            </div>
          </div>
        </div>
        <?php
      	}
      	if($_SESSION['level'] >= 10){
      	    
      	    if($draft_holiday_permission_count > 0){
      	?>
      	<div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden ">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-support"></i>
              </div>
              <a class="text-white clearfix small z-1" href="holiday-list.php">
              	<div class="mr-5">승인 요청 받은 휴가 : <?=$draft_holiday_permission_count?>개</div>
              </a>
            </div>
          </div>
        </div>
        
        <?php
      	    }
      	}
      	
      	if($_SESSION['level'] >= 11){
      	    
      	    if($draft_permission_count > 0){
        ?>
        
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden ">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-shopping-cart"></i>
              </div>
              <a class="text-white clearfix small z-1" href="draft-list.php">
              	<div class="mr-5">승인 요청 받은 기안 : <?=$draft_permission_count?>개</div>
              </a>
            </div>
          </div>
        </div>
        <?php
      	    }
      	}
      	
      	if($_SESSION['id'] == 11){
      	    
      	    if($sales_yet_count > 0){
        ?>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden ">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <a class="text-white clearfix small z-1" href="add-sales.php">
              	<div class="mr-5">세금계산서 발행이 필요한 매출 : <?=$sales_yet_count?>개</div>
              </a>
            </div>
          </div>
        </div>
        <?php
      	    }
      	}
        ?>
      </div>
      
      
      <div class="row">
        <div class="col-lg-8">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-calendar-check-o"></i> 스케쥴 달력
              <div class="card-toggle" ><i class="fa fa-chevron-up" aria-hidden="true" ></i></div>
              <div class="btn-add-schedule" title="스케쥴 추가하기"><i class="fa fa-pencil"></i></div>
            </div>
            
            <div class="card-body">
            	<div class="monthly" id="mycalendar"></div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
      	</div>
      	
      	<div class="col-lg-4">
      	  <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bell-o"></i> 한줄 게시판
			  <div class="card-toggle" ><i class="fa fa-chevron-up" aria-hidden="true" ></i></div>
			</div>
            <div class="card-body card-body-miniboard list-group list-group-flush small">
            	<?php
            	foreach($list as $row){
            	    
            	    $img = '';
            	    
            	    if($row['img'] == '')
            	    {
            	        $img = "./img/noname.png";
            	    }else{
            	        $img = "./img/uploads/".$row['id_acc']."/".$row['img'];
            	    }
            	?>
            	<a class="list-group-item list-group-item-action " href="#">
                  <div class="media">
                    <img class="d-flex mr-3 rounded-circle board-element-img" src="<?=$img?>" alt="">
                    <div class="media-body">
                      <span><strong><?=$row['name']?> <?=$row['position']?>님 </strong><br></span>
                      <?=$row['text']?>
                      <div class="text-muted smaller"><?=$row['date']?></div>
                    </div>
                  </div>
                </a>
            	<?php
            	}
            	?>
              <input class="list-group-item list-group-item-action input-board-mini" placeholder="글을 써서 엔터를 쳐보자.." />
            </div>
            <!-- 
            <div class="card-footer small text-muted">두유 : 멍멍머머멍머엄어멍</div>
            -->
          </div>
      	</div>
      </div>
      
      <div class="row" style="display:none;">
        <div class="col-lg-8">
        
          <!-- Card Columns Example Social Feed-->
          <div class="mb-0 mt-4">
            <i class="fa fa-newspaper-o"></i> News Feed</div>
          <hr class="mt-2">
          <div class="card-columns">
            <!-- Example Social Card-->
            <div class="card mb-3">
              <a href="#">
                <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=610" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">David Miller</a></h6>
                <p class="card-text small">These waves are looking pretty good today!
                  <a href="#">#surfsup</a>
                </p>
              </div>
              <hr class="my-0">
              <div class="card-body py-2 small">
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-thumbs-up"></i>Like</a>
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-comment"></i>Comment</a>
                <a class="d-inline-block" href="#">
                  <i class="fa fa-fw fa-share"></i>Share</a>
              </div>
              <hr class="my-0">
              <div class="card-body small bg-faded">
                <div class="media">
                  <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="">
                  <div class="media-body">
                    <h6 class="mt-0 mb-1"><a href="#">John Smith</a></h6>Very nice! I wish I was there! That looks amazing!
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item">
                        <a href="#">Like</a>
                      </li>
                      <li class="list-inline-item">·</li>
                      <li class="list-inline-item">
                        <a href="#">Reply</a>
                      </li>
                    </ul>
                    <div class="media mt-3">
                      <a class="d-flex pr-3" href="#">
                        <img src="http://placehold.it/45x45" alt="">
                      </a>
                      <div class="media-body">
                        <h6 class="mt-0 mb-1"><a href="#">David Miller</a></h6>Next time for sure!
                        <ul class="list-inline mb-0">
                          <li class="list-inline-item">
                            <a href="#">Like</a>
                          </li>
                          <li class="list-inline-item">·</li>
                          <li class="list-inline-item">
                            <a href="#">Reply</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">Posted 32 mins ago</div>
            </div>
            <!-- Example Social Card-->
            <div class="card mb-3">
              <a href="#">
                <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=180" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">John Smith</a></h6>
                <p class="card-text small">Another day at the office...
                  <a href="#">#workinghardorhardlyworking</a>
                </p>
              </div>
              <hr class="my-0">
              <div class="card-body py-2 small">
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-thumbs-up"></i>Like</a>
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-comment"></i>Comment</a>
                <a class="d-inline-block" href="#">
                  <i class="fa fa-fw fa-share"></i>Share</a>
              </div>
              <hr class="my-0">
              <div class="card-body small bg-faded">
                <div class="media">
                  <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="">
                  <div class="media-body">
                    <h6 class="mt-0 mb-1"><a href="#">Jessy Lucas</a></h6>Where did you get that camera?! I want one!
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item">
                        <a href="#">Like</a>
                      </li>
                      <li class="list-inline-item">·</li>
                      <li class="list-inline-item">
                        <a href="#">Reply</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">Posted 46 mins ago</div>
            </div>
            <!-- Example Social Card-->
            <div class="card mb-3">
              <a href="#">
                <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=281" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">Jeffery Wellings</a></h6>
                <p class="card-text small">Nice shot from the skate park!
                  <a href="#">#kickflip</a>
                  <a href="#">#holdmybeer</a>
                  <a href="#">#igotthis</a>
                </p>
              </div>
              <hr class="my-0">
              <div class="card-body py-2 small">
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-thumbs-up"></i>Like</a>
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-comment"></i>Comment</a>
                <a class="d-inline-block" href="#">
                  <i class="fa fa-fw fa-share"></i>Share</a>
              </div>
              <div class="card-footer small text-muted">Posted 1 hr ago</div>
            </div>
            <!-- Example Social Card-->
            <div class="card mb-3">
              <a href="#">
                <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=185" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">David Miller</a></h6>
                <p class="card-text small">It's hot, and I might be lost...
                  <a href="#">#desert</a>
                  <a href="#">#water</a>
                  <a href="#">#anyonehavesomewater</a>
                  <a href="#">#noreally</a>
                  <a href="#">#thirsty</a>
                  <a href="#">#dehydration</a>
                </p>
              </div>
              <hr class="my-0">
              <div class="card-body py-2 small">
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-thumbs-up"></i>Like</a>
                <a class="mr-3 d-inline-block" href="#">
                  <i class="fa fa-fw fa-comment"></i>Comment</a>
                <a class="d-inline-block" href="#">
                  <i class="fa fa-fw fa-share"></i>Share</a>
              </div>
              <hr class="my-0">
              <div class="card-body small bg-faded">
                <div class="media">
                  <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="">
                  <div class="media-body">
                    <h6 class="mt-0 mb-1"><a href="#">John Smith</a></h6>The oasis is a mile that way, or is that just a mirage?
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item">
                        <a href="#">Like</a>
                      </li>
                      <li class="list-inline-item">·</li>
                      <li class="list-inline-item">
                        <a href="#">Reply</a>
                      </li>
                    </ul>
                    <div class="media mt-3">
                      <a class="d-flex pr-3" href="#">
                        <img src="http://placehold.it/45x45" alt="">
                      </a>
                      <div class="media-body">
                        <h6 class="mt-0 mb-1"><a href="#">David Miller</a></h6>
                        <img class="img-fluid w-100 mb-1" src="https://unsplash.it/700/450?image=789" alt="">I'm saved, I found a cactus. How do I open this thing?
                        <ul class="list-inline mb-0">
                          <li class="list-inline-item">
                            <a href="#">Like</a>
                          </li>
                          <li class="list-inline-item">·</li>
                          <li class="list-inline-item">
                            <a href="#">Reply</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">Posted yesterday</div>
            </div>
          </div>
          <!-- /Card Columns-->
        </div>
        <div class="col-lg-4">
          
         
        </div>
      </div>
	<!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    
    
    <div class="modal fade modal-calendar-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="form-calendar-modify" action="db-modify-row.php" method="post" target="ifr-hidden" >
					<input type="hidden" name="table" value="calendar">
    				<input type="hidden" id="input-id" name="id" value="">
					<input type="hidden" name="db_type" value="insert">
                  
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-12">
                        <label for="input-title" class="label-need">내용</label>
                        <textarea class="form-control" id="input-title" name="title" placeholder="내용" ></textarea>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-5">
                          <label for="input-startdate" class="label-need">시작 날짜</label>
                          <input class="form-control input-calender" id="input-startdate" name="date-start" type="text" data-toggle="datepicker" >
                        </div>
                        <div class="col-md-5">
                          <label for="input-enddate" class="label-need">끝 날짜</label>
                          <input class="form-control input-calender" id="input-enddate" name="date-end" type="text" data-toggle="datepicker" >
                        </div>
                        <div class="col-md-2">
                          <label for="input-color" >배경색</label>
                          <div id="jpicker"></div>
                          <input class="form-control input-calender" id="input-color" name="color" type="hidden" >
                        </div>
                    </div>
                  </div>
                  
                  <a class="btn btn-primary btn-block" id="btn-modify" >등록</a>
              </form>
			</div>
		</div>
    </div>
    

<?php include_once('footer.php') ?>

<script>

$.ajax({
    dataType:"json",
    url:"db-select-row.php?query=SELECT A.*, B.name as acc_name FROM calendar A, account B WHERE A.id_acc = B.id ORDER BY `id` ASC"
}).done(function(data) {

    var events = {"monthly": data };
    
	$('#mycalendar').monthly({
		mode: 'event',
		dataType: 'json',
		events: events,
		id_acc: <?=$_SESSION['id']?>,
		level: <?=$_SESSION['level']?>
	});
});

$(".input-calender").datepicker({
	monthNamesShort: [ "01", "02", "03", "04","05", "06", "07", "08", "09","10", "11", "12" ],
	changeMonth:true,
	showMonthAfterYear: true,
    changeYear:true,
    dateFormat: "yy-mm-dd"
});

$("#input-startdate").change(function() {
	if($("#input-enddate").val().length == 0)
		$("#input-enddate").val($(this).val());
});

$('#jpicker').jPicker({
	window:{
		expandable:true,
		effects:{
			type:"fade"
		},
		position:{
			x: 'screenCenter', /* acceptable values "left", "center", "right", "screenCenter", or relative px value */
			y: 'bottom' /* acceptable values "top", "bottom", "center", or relative px value */
		}
	}
});


$(".modal-calendar-info").on("hidden.bs.modal", function () {
    // put your default event here
	$(".jPicker .Cancel").click();
});

$(".btn-add-schedule").click(function() {
	
	$(".modal-calendar-info").modal();
});


$("#btn-modify").click(function(){
	
	if($("#input-title").val().length == 0){
		
		alert("내용을 적어주세요.");
		return;
	}

	if($("#input-startdate").val().length == 0 || $("#input-enddate").val().length == 0) {

		alert("날짜를 확인해주세요.");
		return;
	}
	
	$("#input-color").val($(".jPicker .Color").css('background-color'));

	$("#form-calendar-modify").submit();
});


$('body').on('click', '.listed-event i', function() {

	if(confirm("스케쥴을 삭제하시겠습니까?")){

		var id = $(this).attr('data-eventid');

        $.post( "db-modify-row.php", { db_type: "delete", table: "calendar", id:id }, function() {
            reload();
        });
	}
});

// 한줄게시판
$(".input-board-mini").keyup(function(e) {
	
	  if(e.keyCode == 13){
		  
		  if($(this).val() == '')
			  return;

		  $.post( "db-modify-board.php", { db_type: "insert", table: "board_mini", id:<?=$_SESSION['id']?>, text:$(this).val() }, function() {
	            reload();
	      });
	  }
});

</script>

</body>
</html>