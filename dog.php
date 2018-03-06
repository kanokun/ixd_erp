<?php
include_once('header.php');
include_once('nav.php');

$table = "account";


$stmt = $dbh->prepare("SELECT A.*,B.name as company_self_name, C.name as company_name, D.name as type_name, E.name as acc_name FROM $table A, company_self B, company C, type_purchase D, account E WHERE A.id_comp_self = B.id AND A.id_comp = C.id AND A.id_type = D.id AND A.id_acc = E.id ORDER BY date DESC");

$stmt->execute();
$list = $stmt->fetchAll();
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">개</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 핥는 개
        </div>
        <div class="card-body">
        	<video width="100%"  autoplay loop muted>
                <source src="./etc/pug.mp4" type="video/mp4" />
            </video>
        </div>
      </div>
    </div>
    
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

<?php include_once('footer.php') ?>

<script>

</script>