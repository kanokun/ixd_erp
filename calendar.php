<?php
include_once('header.php');
include_once('nav.php');

?>

  
    <div class="container-fluid">
    	<div class="monthly" id="mycalendar"></div>
    </div>

<?php include_once('footer.php') ?>
    
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script>
    $.ajax({
        dataType:"json",
        url:"db-select-row.php?query=SELECT A.*, B.name as acc_name FROM calendar A, account B WHERE A.id_acc = B.id ORDER BY `id` ASC"
    }).done(function(data) {

        var events = {"monthly": data };
        
    	$('#mycalendar').monthly({
    		mode: 'event',
    		dataType: 'json',
    		events: events
    	});        
    });
	
    
    </script>

</body>
</html>