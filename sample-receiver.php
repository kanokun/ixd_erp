<?php
include_once('header.php');
include_once('nav.php');

$table = "sample_receiver";

$stmt = $dbh->prepare("SELECT A.*,B.name FROM $table A, account B WHERE A.id_sender = B.id ORDER BY name ASC");

$stmt->execute();
$list = $stmt->fetchAll();
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">무료 구독자</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 무료 구독자 리스트
          <div class="card-toggle"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          	<div class="td-btn"><a class="btn btn-sm btn-primary dl-xls">엑셀로 다운</a></div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>담당자</th>
                  <th>수신처</th>
                  <th>주소</th>
                  <th>연락처</th>
                  <th>IXD</th>
                  <th>데코</th>
                  <th>주락</th>
                  <th>비고</th>
                </tr>
              </thead>
              <tbody>
				<?php
				
				$ixd = 0;
				$deco = 0;
				$jurak = 0;
				
                foreach($list as $row){
                    
                    $ixd += intval($row['ixd']);
                    $deco += intval($row['deco']);
                    $jurak += intval($row['jurak']);
                ?>
                <tr>
                	<td><?=$row['name']?></td>
                	<td><?=$row['receiver']?></td>
                	<td><?=$row['addr']?></td>
                	<td><?=$row['phone']?></td>
                	<td><?=$row['ixd']?></td>
                	<td><?=$row['deco']?></td>
                	<td><?=$row['jurak']?></td>
                	<td><?=$row['etc']?></td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted card-footer-cost">
        	<span>IXD : </span>
			<span class="footer-ixd"><?=$ixd?></span>
			<span> 권 / 데코 : </span>
			<span class="footer-deco"><?=$deco?></span>
			<span> 권 / 주락 : </span>
			<span class="footer-jurak"><?=$jurak?></span>
			<span> 권</span>
		</div>
      </div>
    </div>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

<?php include_once('footer.php') ?>

<script>
$('#dataTable').DataTable({
    "order": [[0, "asc"]]
});
</script>

</body>
</html>