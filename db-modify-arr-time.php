<?php
include_once 'include/kan_session.class.php';
$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$table = $_POST['table'];
$db_type = $_POST['db_type'];


switch($db_type) {
    case "insert":

        $late = $_POST['late'];
        $reason = $_POST['reason'];
        $reason_type = $_POST['reason_type'];
        $time = $_POST['time'];
        $compare_time = $_POST['compare-time'];
        
        if($late == -1) {
            
            $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`, `time`, `late`, `reason`, `reason_type`) VALUES (".$_SESSION['id'].",'$time',$late,'$reason','$reason_type')");
            $stmt->execute();
            
        }else{
            
            //$query = "INSERT INTO $table (`id_acc`, `time`, `compare_time`, `late`, `reason`, `reason_type`) VALUES (".$_SESSION['id'].",'$time','$compare_time',$late,'$reason','$reason_type')";
            
            $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`, `time`, `compare_time`, `late`, `reason`, `reason_type`) VALUES (".$_SESSION['id'].",'$time','$compare_time',$late,'$reason','$reason_type')");
            $stmt->execute();
        }
        
        /*
        
        $next_time = date("Y-m-d", strtotime($time." +1 days"));
        
        ?>
        <script>
        //alert('<?=$next_time?>');
        </script>
        <?php
        
        //$stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`text`) VALUES ($id,'$text')");
        //$stmt->execute();
        ?>
        <script>
        parent.arrTimeCheck("<?=$next_time?>");
        </script>
        <?php
        */
        break;

    case "update":
        break;
    
    case "delete":
        break;

    default: 
        break;
}
?>