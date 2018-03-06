<?php
include_once('header.php');
include_once('nav.php');

$table = "holiday";

$stmt = $dbh->prepare("SELECT * FROM $table WHERE id_acc = ".$_SESSION['id']." ORDER BY date DESC");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT holiday FROM account WHERE id = ".$_SESSION['id']." LIMIT 1");
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
        <li class="breadcrumb-item active">내 휴가 내역</li>
      </ol>
      <!-- Example DataTables Card-->

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 휴가 내역
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>날짜</th>
                  <th>비고</th>
                  <th>휴가 일</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($list as $row){
                  
                  $count = $row['count'];
                  $count = $count * 1;
                  
                  if($count > 0)
                      $count = '+'.$count;
              ?>
              	<tr>
              		<td><?=$row['date_start']?></td>
              		<td><?=$row['etc']?></td>
              		<td><?=$count?></td>
              	</tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">남은 휴가 일 수 : <?=$count_final?></div>
      </div>
    </div>

<?php include_once('footer.php') ?>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

</body>
</html>
