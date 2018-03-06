<?php
$dbh = new PDO('mysql:host=localhost;dbname=ixd_erp','root','qlalfqjs1', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$id = $_POST['id'];

$uploaddir = '/home/kanokun/public_html/erp/img/uploads/'.$id.'/';
$uploadfile = $uploaddir . basename($_FILES['img']['name']);

@mkdir($uploaddir, 0777);

if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
    
    $stmt = $dbh->prepare("UPDATE account SET `img`='".$_FILES['img']['name']."' WHERE `id`=$id LIMIT 1");
    $stmt->execute();
?>
<script>
alert("업로드 되었습니다.");
parent.reload();
</script>
<?php
} else {
?>
<script>
alert("업로드가 실패하였습니다.");
</script>
<?php
}
?>