<?php
include_once('header.php');
include_once('nav.php');

$table = "draft";
?>

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/erp">홈</a>
        </li>
        <li class="breadcrumb-item active">기안서 보기</li>
      </ol>
      <!-- Example DataTables Card-->

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> 기안서 리스트
        </div>

        <div class="card-body card-tab">

        	<ul class="nav nav-tabs">
    			<li id="_tab_0" class="_tab _tab_0 active">
            		<a href="#0" data-toggle="tab">전체</a>
    			</li>
    			<li id="_tab_1" class="_tab _tab_1">
            		<a href="#1" data-toggle="tab">완료</a>
    			</li>
    			<li id="_tab_2" class="_tab _tab_2">
            		<a href="#2" data-toggle="tab">미완료</a>
    			</li>
    			<li id="_tab_3" class="_tab _tab_3">
            		<a href="#3" data-toggle="tab">기각</a>
    			</li>
    		</ul>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>날짜</th>
                  <th>작성자</th>
                  <th>제목</th>
                  <th>단계</th>
                  <th>기타</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">이젠 정말 로또 뿐이야. 내 인생 로또 뿐이라구!</div>
      </div>
    </div>

<?php include_once('footer.php') ?>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script>

    var tab_idx = "0";

    function setDraft() {

    	var query = "SELECT A.*, B.name FROM <?=$table?> A, account B ";
    	var where = "";

    	if(tab_idx == "1")
    		where += "AND A.level = 10 ";
    	else if(tab_idx == "2")
        	where += "AND (A.level != 10 AND A.level >= 0) ";
    	else if(tab_idx == "3")
        	where += "AND A.level < 0 ";

    	<?php
    	if($_SESSION['level'] < 10){
    	?>
    		where += "AND A.id_acc = <?=$_SESSION['id']?> ";
    	<?php
    	}
    	?>

    	query += "WHERE A.id_acc = B.id ";
        	
    	if(where.length != 0)
        	query += where;
    	
    	query += "ORDER BY date DESC";
    	

    	$.ajax({
            dataType:"json",
            url:"db-select-row.php?query=" + query
        }).done(function(data) {
        	
            // 이 밑으로는 테이블
            var _html = "";
            var _level = "";

            if(data != null){
                
            	data.forEach(function(e,i){

            		switch(e['level'])
					{
                    case "-3":
                    	_level = "대표님 기각";
                        break;
                    case "-2":
                    	_level = "이사님 기각";
                        break;
                    case "-1":
                    	_level = "과장님 기각";
                        break;
                    case "0":
                    	_level = "과장님 결제 대기";
                        break;
                    case "1":
                    	_level = "이사님 결제 대기";
                        break;
                    case "2":
                    	_level = "대표님 결제 대기";
                        break;
                    case "10":
                    	_level = "결제 완료";
                        break;
                    }

                	_html += '<tr><td>'+e['date']+'</td>';
                	_html += '<td>'+e['name']+'</td>';
                	_html += '<td>'+e['title']+'</td>';
                	_html += '<td>'+_level+'</td>';
                	_html += '<td><a class="btn btn-sm btn-primary btn-draft-info" id="btn-draft-info-' + e['id'] + '">상세</a></td></tr>';
                });
            }

            if(_table != null)
            	_table.destroy();

            $("tbody").html(_html);
            
            _table = $('#dataTable').DataTable({
              "order": [[0, "desc"]]
            });
            
        });
    }
    
    
    $("._tab").click(function(){	

    	$("._tab").removeClass("active");
    	$(this).addClass("active");

    	var _id = $(this).attr('id').split('_');
    	_id = _id[_id.length-1];

    	tab_idx = _id;

    	setDraft();
    });

    $(".btn-modify").click(function() {

    	var id = $(this).attr('id').split('-');
        id = id[id.length-1];

        $("#input2-id").val(id);

        $.ajax({
            dataType:"json",
            url:"db-select-row.php?query=SELECT * FROM <?=$table?> WHERE `id`=" + id + " limit 1"
        }).done(function(data) {

        	$(".input2").attr("readonly", false);
        	$("#input2-etc").removeAttr("readonly");
        	
        	$("#input2-name").val(data[0].name);
        	$("#input2-email").val(data[0].email);
        	$("#input2-phone").val(data[0].phone);
        	$("#input2-fax").val(data[0].fax);
        	$("#input2-admin").val(data[0].admin);
        	$("#input2-code").val(data[0].code);
        	$("#input2-etc").val(data[0].etc);

        	$("#btn-modify").css('display','block');
        	
        	$(".modal-company-info").modal();
        });
    });
    

    $(".btn-delete").click(function() {

        var r = confirm("정말 삭제하시겠습니까?");
        
        if(!r){
            return;
        }else{
        	var id = $(this).attr('id').split('-');
            id = id[id.length-1];

            $.post( "db-modify-row.php", { db_type: "delete", table: "<?=$table?>", id:id }, function() {
                reload();
            });
        }
    });

    $('body').on('click', '.btn-draft-info', function() {
        
    	var _idx = $(this).attr('id').split('-');
    	_idx = _idx[_idx.length-1];

    	 var $form = $('<form></form>');
         $form.attr('action', 'draft.php');
         $form.attr('method', 'post');
         $form.appendTo('body');
         
         var idx = $('<input type="hidden" value="'+_idx+'" name="idx">');
     
         $form.append(idx);
         $form.submit();
    });
    

    var _table = $('#dataTable').DataTable({
        "order": [[0, "desc"]]
    });

    setDraft();
    </script>

</body>
</html>
