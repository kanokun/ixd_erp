<?php
include_once 'include/kan_session.class.php';

// 로그인 되어있지 않다면 로그인 화면으로 강제이동.
if((!$kan_session->checkId()) && (!(basename($_SERVER["PHP_SELF"]) == "index.php"))){
?>
<script>
alert("로그인을 먼저 해주세요.");
location.href="/erp";
</script>
<?php
    exit;
}

$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="매입, 매출, 세금계산서, 일정관리, 기안서">
  <meta name="author" content="">
  <title>IXD ERP 시스템 입니다.</title>
  
  <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
  <link href="vendor/monthly/css/monthly.css" rel="stylesheet">
  
  <link href="vendor/jpicker/css/jPicker-1.1.6.css" rel="stylesheet">
  
  <link href="css/common.css" rel="stylesheet">
  
  <link rel="stylesheet" href="./vendor/daumEditor/css/editor.css" type="text/css" charset="utf-8"/>
</head>
