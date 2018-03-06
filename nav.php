<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top hide-print" id="mainNav">
    <a class="navbar-brand" href="home.php">IXD ERP</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="홈">
          <a class="nav-link" href="home.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">홈</span>
          </a>
        </li>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="홈">
          <a class="nav-link" href="user.php">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">내 정보</span>
          </a>
        </li>
        
        <?php
        if($_SESSION['level'] > 5) {
        ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="매출">
          <a class="nav-link" href="sales.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">매출</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="매입">
          <a class="nav-link" href="purchase.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">매입</span>
          </a>
        </li>
        <?php
        }
        if($_SESSION['level'] >= 10) {
        ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="잡지판매 현황">
          <a class="nav-link" href="magazine.php">
            <i class="fa fa-fw fa-book"></i>
            <span class="nav-link-text">잡지판매 현황</span>
          </a>
        </li>
        <?php
        }
        ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="무료 구독자 현황">
          <a class="nav-link" href="sample-receiver.php">
            <i class="fa fa-fw fa-building-o"></i>
            <span class="nav-link-text">무료 구독자 현황</span>
          </a>
        </li>
        <?php
        if($_SESSION['level'] > 5) {
        ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="데이터 관리">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">데이터 관리</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
          	<?php
          	if($_SESSION['level'] >= 10) {
          	?>
          	<li>
              <a href="add-magazine-sales.php">잡지판매 현황 관리</a>
            </li>
          	<?php
          	}
          	?>
          	<li>
              <a href="add-sample-receiver.php">무료 구독자 관리</a>
            </li>
          	<li>
              <a href="add-sales.php">매출 관리</a>
            </li>
          	<li>
              <a href="add-purchase.php">매입 관리</a>
            </li>
            <li>
              <a href="add-company-self.php">자회사 관리</a>
            </li>
            <li>
              <a href="add-company.php">거래처 관리</a>
            </li>
            <li>
              <a href="add-type-sales.php">매출품목 관리</a>
            </li>
            <li>
              <a href="add-type-purchase.php">매입품목 관리</a>
            </li>
            <!-- 
            <li>
              <a href="add-excel.php">엑셀파일 넣기</a>
            </li>
             -->
          </ul>
        </li>
        
        <?php
        }
        ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="기안서 관리">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents2" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-file-text-o"></i>
            <span class="nav-link-text">기안서 관리</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents2">
          	<li>
              <a href="add-draft.php">기안서 작성</a>
            </li>
            <li>
              <a href="draft-list.php">기안서 보기</a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="기안서 관리">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents3" data-parent="#exampleAccordion">
            <i class="fa fa-bicycle" aria-hidden="true"></i>
            <span class="nav-link-text">휴가 관리</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents3">
          	<li>
              <a href="holiday-history.php">내 휴가 내역</a>
            </li>
          	<li>
              <a href="add-holiday.php">휴가 신청</a>
            </li>
            <?php
            if($_SESSION['level'] >= 10) {
            ?>
            <li>
              <a href="holiday-list.php">휴가 승인</a>
            </li>
            <?php
            }
            if($_SESSION['level'] >= 10) {
            ?>
            <li>
              <a href="holiday-send.php">휴가 주기</a>
            </li>
            <?php
            }
            ?>
          </ul>
        </li>
        
        <?php
        if($_SESSION['id'] == 2) {
        ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="홈">
          <a class="nav-link" href="dog.php">
            <i class="fa fa-fw fa-smile-o"></i>
            <span class="nav-link-text">핥는 개</span>
          </a>
        </li>
        <?php
        }
        ?>
        
        <!-- 
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="charts.php">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Charts</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="tables.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Tables</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents_" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Components</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents_">
            <li>
              <a href="navbar.php">Navbar</a>
            </li>
            <li>
              <a href="cards.php">Cards</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Example Pages</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a href="login.php">Login Page</a>
            </li>
            <li>
              <a href="register.php">Registration Page</a>
            </li>
            <li>
              <a href="forgot-password.php">Forgot Password Page</a>
            </li>
            <li>
              <a href="blank.php">Blank Page</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Menu Levels</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a href="#">Second Level Item</a>
            </li>
            <li>
              <a href="#">Second Level Item</a>
            </li>
            <li>
              <a href="#">Second Level Item</a>
            </li>
            <li>
              <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Third Level</a>
              <ul class="sidenav-third-level collapse" id="collapseMulti2">
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-link"></i>
            <span class="nav-link-text">Link</span>
          </a>
        </li>
        -->
      </ul>
       
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
      <!-- 
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all alerts</a>
          </div>
        </li>
         -->
        <li class="nav-item">
			<div class="nav-login-info">
				<?=$_SESSION['name']?> [<?=$_SESSION['position']?>]
        	</div>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div id="container-main" class="content-wrapper">
