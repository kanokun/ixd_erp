<form method="post" action="./md5.php">
	<input type="password" name="pwd" placeholder="비밀번호">
	<input type="submit" value="암호화">
</form>

<?php
if($_POST['pwd'] != '')
    echo "암호화된 비밀번호 : ".md5($_POST['pwd']);
?>