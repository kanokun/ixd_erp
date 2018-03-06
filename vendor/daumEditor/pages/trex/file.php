<?php
$uploads_dir = '/home/kanokun/public_html/erp/file/uploads';
$files = [];

for($i=0; $i<count($_FILES['upload_files']['name']); $i++) {
    
    $files[$i] = [];
    $files[$i]['name'] = $_FILES['upload_files']['name'][$i];
    $files[$i]['full'] = 'http://192.168.168.119/erp/file/uploads/'.$files[$i]['name'];
    $files[$i]['size'] = $_FILES['upload_files']['size'][$i];
    $files[$i]['mime'] = mime_content_type($_FILES['upload_files']['tmp_name'][$i]);

    move_uploaded_file($_FILES['upload_files']['tmp_name'][$i], $uploads_dir.'/'.$files[$i]['name']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Daum에디터 - 파일 첨부</title> 
<script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="../../css/popup.css" type="text/css"  charset="utf-8"/>
<script src="/erp/vendor/jquery/jquery.js"></script>
<script type="text/javascript">
// <![CDATA[
	
	var _opener;
	
	function done() {
		
		if (typeof(execAttach) == 'undefined') { //Virtual Function
	        return;
	    }

	    var _mockdata = [];
	    
		/*
		var _mockdata = {
			'attachurl': 'http://cfile297.uf.daum.net/attach/207C8C1B4AA4F5DC01A644',
			'filemime': 'image/gif',
			'filename': 'editor_bi.gif',
			'filesize': 640
		};
		*/

		<?php
		
		for($i=0; $i<sizeof($files); $i++) {
		?>
			_mockdata.push({'attachurl':'<?=$files[$i]['full']?>',
                			'filemime':'<?=$files[$i]['mime']?>',
                			'filename':'<?=$files[$i]['name']?>',
                			'filesize':<?=$files[$i]['size']?>});
		<?php
		}
		/*
		for($i=0; $i<count($_FILES['upload_files']['name']); $i++) {
		?>

		_mockdata.push({'attachurl':'<?=$_FILES['upload_files']['tmp_name'][$i]?>',
						'filemime':'<?=mime_content_type($_FILES['upload_files']['tmp_name'][$i])?>',
						'filename':'<?=$_FILES['upload_files']['name'][$i]?>',
						'filesize':<?=$_FILES['upload_files']['size'][$i]?>});
		<?php
		}
		*/
		?>
		
		for(var i=0; i<_mockdata.length; i++) {
			//_opener.Editor.getSidebar().getAttacher(_mockdata[i].attacher).attachHandler(_mockdata[i]);
			execAttach(_mockdata[i]);
		}

		closeWindow();
	}

	function initUploader(){
	    _opener = PopupUtil.getOpener();
	    if (!_opener) {
	        alert('잘못된 경로로 접근하셨습니다.');
	        return;
	    }
	    
	    var _attacher = getAttacher('file', _opener);
	    registerAction(_attacher);
	}
	
</script>
</head>
<body>


<?php
echo count($_FILES['upload_files']['name']);

foreach ($_FILES['upload_files']['name'] as $file) {
    echo '<li>' . $file . '</li>';
}
?>

<script>
initUploader();
done();
</script>

</body>
</html>
