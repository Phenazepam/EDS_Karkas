<?php

use RedCore\Controller;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/images/icons/favicon.png">
  <title>КАРКАС</title>

  <!-- Bootstrap -->
  <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="/template/general/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="/template/general/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="/template/general/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="/template/general/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="/template/general/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">



  <!-- Custom Theme Style -->
  <link href="/template/general/build/css/custom.min.css" rel="stylesheet">

  <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/themes/dataviz.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

  <!-- Datatables -->

  <link href="/template/general/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="/template/general/custom/breadcrumbs/breadcrumbs.css">

</head>

<body class="nav-md">
  <!-- jQuery -->
  <script src="/template/general/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Вешаем спиннер до полной загрузки страницы -->
  <script src="/template/general/custom/load_spinner/spinner.js"></script>
  <link rel="stylesheet" href="/template/general/custom/load_spinner/spinner.css">

  <!-- <script src="/template/general/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/template/general/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="/template/general/vendors/datatables.net/js/any-number.js"></script> -->

  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title"><i class="fa fa-building"></i> <span>АИС</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Здравствуйте,</span>
              <?php

              use RedCore\Users\Collection as Users;
              use RedCore\Indoc\Collection as Indoc;

              Users::setObject("user");
              $role_user = Users::getAuthRole();
              $user = Users::getRolesList();
              $c_user = Users::getAuthToken();
              $user_role = Users::getAuthRole();
              $user_id = Users::getAuthId();

              $lb_params = array(
                "token_key" => $c_user
              );

              $c_user = Users::loadBy($lb_params);
              ?>
              <h2><?= $c_user->object->params->f ?> <?= $c_user->object->params->i ?></h2>
              <br>
              <h2><?= $user[$role_user]?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Мониторинг</h3>
              <ul class="nav side-menu">
				<li>
					<a href="/">
                    <i class="fa fa-dashboard"></i> Дашбоард
                  </a>
           
                </li>
			  
                <li>
					
                  <a>
                    <i class="fa fa-file"></i> Мои документы 
                    <span class="badge badge-light" style="margin-left: 20px;"><?php echo Indoc::NumberDocs(-1, $user_role, $user_id);?></span>
                    <span class="fa fa-chevron-down"></span>
                  </a>
                  <ul class="nav child_menu">
                    <li><a href="/indocitems-list?my_doc_status=1">Черновики 
                    	<span class="badge badge-light" style="margin-left: 20px;"><?php echo Indoc::NumberDocs(1,  $user_role, $user_id);?></span></a></li>
                    <li><a href="/indocitems-list?my_doc_status=2">На согласование
                    	<span class="badge badge-light" style="margin-left: 20px;"><?php echo Indoc::NumberDocs(2,  $user_role, $user_id);?></span></a></li>
                    <li><a href="/indocitems-list?my_doc_status=3">На утверждение
                    	<span class="badge badge-light" style="margin-left: 20px;"><?php echo Indoc::NumberDocs(3,  $user_role, $user_id);?></span></a></li>
                    <li><a href="/indocitems-list?my_doc_status=4">На принятие
                    	<span class="badge badge-light" style="margin-left: 20px;"><?php echo Indoc::NumberDocs(4,  $user_role, $user_id);?></span></a></li>
                  </ul>
                </li>
                <li>
					<a href="/indocitems-list?my_doc_status=5">
                    	<i class="fa fa-file"></i> Хранилище документов
                  	</a>
                </li>
              </ul>
            </div>
            <!-- <div class="menu_section">
              <h3>Отдел продаж</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-line-chart"></i> План продаж <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="/chess">Шахматка</a></li>
                  </ul>
                </li>
              </ul>
            </div> -->
            <div class="menu_section">
              <h3>Данные</h3>
              <?php 
                $mainPageModules = require('MainPageModules.php');
                Users::setObject("user");
                foreach($mainPageModules as $moduleKey => $module):
                  if(Users::CanUserSeeModule($user_role, $moduleKey)):
              ?>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-info"></i> <?=$module["name"]?> <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                    $menu = Controller::Search("pages", $module["tag"]);
                      foreach ($menu as $item) :
                      ?>
                        <li><a href="/<?= $item["url"] ?>"><?= $item["title"] ?></a></li>
                      <?php
                      endforeach;
                    endif;
                    ?>
                  </ul>
                </li>
              </ul>
              <?endforeach;?>

            </div>
          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/img.jpg" alt="">Пользователь
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Профиль</a>
                  <a class="dropdown-item" href="javascript:;">
                    <span>Настройки</span>
                  </a>
                  <a class="dropdown-item" href="javascript:;">Помощь</a>
                  <a class="dropdown-item" href="/?action=user.logout.do"><i class="fa fa-sign-out pull-right"></i> Выйти</a>
                </div>
              </li>

              <li role="presentation" class="nav-item dropdown open">
                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>Пользователь</span>
                        <span class="time">3 минуты назад</span>
                      </span>
                      <span class="message">
                        Информационное сообщение
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <div class="text-center">
                      <a class="dropdown-item">
                        <strong>Посмотреть все сообщения</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <? Controller::Load(); ?>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          FOOTER
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>
  <!-- Bootstrap -->
  <script src="/template/general/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="/template/general/vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="/template/general/vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="/template/general/vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- jQuery Sparklines -->
  <script src="/template/general/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- morris.js -->
  <script src="/template/general/vendors/raphael/raphael.min.js"></script>
  <script src="/template/general/vendors/morris.js/morris.min.js"></script>
  <!-- gauge.js -->
  <script src="/template/general/vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="/template/general/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- Skycons -->
  <script src="/template/general/vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="/template/general/vendors/Flot/jquery.flot.js"></script>
  <script src="/template/general/vendors/Flot/jquery.flot.pie.js"></script>
  <script src="/template/general/vendors/Flot/jquery.flot.time.js"></script>
  <script src="/template/general/vendors/Flot/jquery.flot.stack.js"></script>
  <script src="/template/general/vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="/template/general/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="/template/general/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="/template/general/vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="/template/general/vendors/DateJS/build/date.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="/template/general/vendors/moment/min/moment.min.js"></script>
  <script src="/template/general/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- jQuery Knob -->
    <script src="/template/general/vendors/jquery-knob/dist/jquery.knob.min.js"></script>


  <!-- Custom Theme Scripts -->
  <script src="/template/general/build/js/custom.min.js"></script>

  <!-- iCheck -->
  <script src="/template/general/vendors/iCheck/icheck.min.js"></script>
  
  <!-- <script src="/template/general/vendors/pdfmake/build/pdfmake.min.js"></script> -->
  <!-- <script src="/template/general/vendors/pdfmake/build/vfs_fonts.js"></script> -->
  <!-- DatePicker -->
  <script src="/template/general/vendors/datepicker/daterangepicker.js"></script>

  <!-- Sweet Alert 2 -->
  <script src="/template/general/vendors/sweetAlert/sweetalert2.all.min.js"></script>
  <!-- Search-select -->
  <script src="/template/general/vendors/search-select/bootstrap-select.min.js"></script>
  <link rel="stylesheet" href="/template/general/vendors/search-select/bootstrap-select.css">
  <!-- Datatables -->
  <script src="/template/general/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/template/general/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="/template/general/vendors/datatables.net/js/any-number.js"></script>
  <script src="/template/general/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="/template/general/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="/template/general/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="/template/general/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="/template/general/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="/template/general/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="/template/general/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="/template/general/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="/template/general/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="/template/general/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="/template/general/vendors/jszip/dist/jszip.min.js"></script>

  
  
</body>


</html>