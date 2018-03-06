<?php
include_once 'include/kan_session.class.php';

$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$nick = $_POST['nick'];
$pwd = $_POST['password'];
//$remember = $_POST['remember'];

$table = "account";

// 로그인 계정 존재여부 체크
$stmt = $dbh->prepare("SELECT * FROM $table WHERE `nick`='$nick' AND `pwd`='".md5($pwd)."' LIMIT 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($stmt->rowCount() == 1) {
    
    $kan_session->addId($nick);
    $kan_session->add("position",$row['position']);
    $kan_session->add("name",$row['name']);
    $kan_session->add("id",$row['id']);
    $kan_session->add("level",$row['level']);
    $kan_session->add("img",$row['img']);
    /*
    if($remember == "on") {
        $kan_session->add("pwd", $pwd);
    }
    */
?>
<script>
//alert("<?=isset($_SESSION['account_id'])?>");
parent.location.href="/erp/home.php";
</script>
<?php
}else{
?>
<script>
alert("아이디 또는 비밀번호가 잘못되었습니다.");
</script>
<?php
}
?>