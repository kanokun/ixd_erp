<?php
include_once 'include/kan_session.class.php';
$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$table = $_POST['table'];
$db_type = $_POST['db_type'];


switch($db_type) {
    case "insert":
        
        switch($table) {
            
            case "board_mini":
                
                $id = $_POST['id'];
                $text = $_POST['text'];
                
                $stmt = $dbh->prepare("INSERT INTO $table (`id_acc`,`text`) VALUES ($id,'$text')");
                $stmt->execute();
                
                break;
        }
        
         
        break;

    case "update":
        break;
        
    case "delete":
        break;
        
    default: 
        break;
}
?>