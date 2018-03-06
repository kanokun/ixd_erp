<?php
include_once 'include/kan_session.class.php';
$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$table = $_POST['table'];
$db_type = $_POST['db_type'];
$type = $_POST['type'];
$id = $_POST['id'];

switch($db_type) {
    
    case "insert":
        break;

    case "update":
        
        $etc = $_POST['etc'];
        $level = $_POST['level'];
        
        $query = "UPDATE $table SET `etc`='$etc', `level`=";
        
        if($type == 'reject') {
            
            switch($_SESSION['id']) {
                    
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
            
        }else if($type == 'draft') {
            
            switch($_SESSION['id']) {
                
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