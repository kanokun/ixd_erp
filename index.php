<?php
include_once('header.php');

if($kan_session->checkId())
{
?>
<script>
location.href="/erp/home.php";
</script>
<?php
    exit;
}
?>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">IXD ERP Login</div>
      <div class="card-body">
        <form id="form-login" action="login-check.php" method="post" target="ifr-hidden" >
          <div class="form-group">
            <label for="login-nick">ID</label>
            <input class="form-control" id="login-nick" name="nick" type="text" placeholder="Enter ID">
          </div>
          <div class="form-group">
            <label for="login-pwd">Password</label>
            <input class="form-control" id="login-pwd" name="password" type="password" placeholder="Password" >
          </div>
          <!-- 
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" name="remember" type="checkbox"> 비밀번호 저장</label>
            </div>
          </div>
           -->
          <a class="btn btn-primary btn-block" id="btn-login">Login</a>
        </form>
      </div>
    </div>
  </div>
  
  <iframe class="_hide" id="ifr-hidden" name="ifr-hidden"></iframe>
  
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  
  <script>
  $("#btn-login").click(function(){
	  var _id = $("#login-nick").val();
	  var _pwd = $("#login-pwd").val();

	  if(_id.length == 0)
	  {
		  alert("아이디를 입력해주세요.");
		  return;
	  }

	  if(_pwd.length == 0)
	  {
		  alert("비밀번호를 입력해주세요.");
		  return;
	  }

	  $("#form-login").submit();
  });

  $("input").keyup(function(e) {
	  if(e.keyCode == 13)
		  $("#btn-login").click();
  });
  </script>
</body>

</html>
