<?php
include_once 'include/kan_session.class.php';
$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$table = $_POST['table'];
$db_type = $_POST['db_type'];
$type = $_POST['type'];
$id = $_POST['id'];

switch($db_type) {
    
    case "insert":
        
        $id_acc = $_POST['id_acc'];
        $count = $_POST['count'];
        $etc = $_POST['etc'];
        
        if($id_acc == 0) {
            
            $stmt = $dbh->prepare("SELECT * FROM account");
            $stmt->execute();
            $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($list as $row){
                
                if($row['level'] > 10)
                    continue;
                
                $query = "INSERT INTO $table (`id_acc`, `id_acc_send`, `date_start`, `count`, `etc`) VALUES (".$row['id'].", ".$_SESSION['id'].", '".date("Y/m/d")."', $count, '$etc')";
                $stmt = $dbh->prepare($query);
                $stmt->execute();
                
                $stmt = $dbh->prepare("UPDATE account SET `holiday`=holiday+".$count." WHERE `id`=".$row['id']." LIMIT 1");
                $stmt->execute();
            }
            
        }else{
            
            $query = "INSERT INTO $table (`id_acc`, `id_acc_send`, `date_start`, `count`, `etc`) VALUES ($id_acc, ".$_SESSION['id'].", '".date("Y/m/d")."', $count, '$etc')";
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            
            $stmt = $dbh->prepare("UPDATE account SET `holiday`=holiday+".$count." WHERE `id`=".$id_acc." LIMIT 1");
            $stmt->execute();
        }
        
        break;

    case "update":
        
        $query = "UPDATE $table SET `level`=";
        $reason = $_POST['reason'];
        $level = $_POST['level'];
        
        if($type == 'reject') {
            
            switch($_SESSION['id']) {
                
                case 11:
                    $query .= -1;
                    break;
                    
                case 13:
                    $query .= -2;
                    break;
                    
                case 12:
                    $query .= -3;
                    break;
                    
                case 1:
                    if($level == 0)
                        $query .= -1;
                        
                    if($level == 1)
                        $query .= -2;
                    
                    if($level == 2)
                        $query .= -3;
                    
                    break;
            }
            
            $query .= ", `reason`='$reason'";
            
        }else if($type == 'allow') {
            
            switch($_SESSION['id']) {
                
                case 11:
                    $query .= 1;
                    break;
                    
                case 13:
                    $query .= 2;
                    break;
                    
                case 12:
                    $query .= 10;                    
                    break;
                    
                case 1:
                    if($level == 0)
                        $query .= 1;
                        
                    if($level == 2)
                        $query .= 2;
                        
                    if($level == 2)
                        $query .= 10;
                        
                    break;
            }
        }

        $query .= " WHERE `id`=$id LIMIT 1";
        
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        
        
        if($type == 'allow' && $_SESSION['id'] == 12) {
            
            $stmt = $dbh->prepare("SELECT * FROM draft_holiday WHERE id=$id LIMIT 1");
            $stmt->execute();
            $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($list as $row){
                
                $stmt = $dbh->prepare("INSERT INTO holiday (`id_acc`, `date_start`, `count`, `etc`) VALUES (".$row['id_acc'].",'".$row['date_start']."', -".$row['count'].",'".$row['etc']."')");
                $stmt->execute();
                
                $stmt = $dbh->prepare("UPDATE account SET `holiday`=holiday-".$row['count']." WHERE `id`=".$row['id_acc']." LIMIT 1");
                $stmt->execute();
            }
        }
        
        if($type == 'allow' && $_SESSION['id'] == 1 && $level == 2) {
            
            $stmt = $dbh->prepare("SELECT * FROM draft_holiday WHERE id=$id LIMIT 1");
            $stmt->execute();
            $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($list as $row){
                
                $stmt = $dbh->prepare("INSERT INTO holiday (`id_acc`, `date_start`, `count`, `etc`) VALUES (".$row['id_acc'].",'".$row['date_start']."', -".$row['count'].",'".$row['etc']."')");
                $stmt->execute();
                
                $stmt = $dbh->prepare("UPDATE account SET `holiday`=holiday+".$row['count']." WHERE `id`=".$row['id_acc']." LIMIT 1");
                $stmt->execute();
            }
        }
        
        break;
        
    case "delete":
        break;
        
    default: 
        break;
}
?>

<script>
parent.reload();
</script>