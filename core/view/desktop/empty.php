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
  <title>БАУИНВЕСТ</title>

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

  <!-- <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/themes/dataviz.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script> -->

  <!-- Datatables -->

  <!-- <link href="/template/general/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="/template/general/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->


</head>
<body>
      <!-- page content -->
      <div id="no-layout">
        <? Controller::Load(); ?>
      </div>
      <!-- /page content -->

  <!-- jQuery -->
  <script src="/template/general/vendors/jquery/dist/jquery.min.js"></script>
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

  <!-- Custom Theme Scripts -->
  <script src="/template/general/build/js/custom.min.js"></script>

  <!-- iCheck -->
  <script src="/template/general/vendors/iCheck/icheck.min.js"></script>
  <!-- Datatables -->
  <script src="/template/general/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/template/general/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
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
  <script src="/template/general/vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="/template/general/vendors/pdfmake/build/vfs_fonts.js"></script>
  <!-- DatePicker -->
  <script src="/template/general/vendors/datepicker/daterangepicker.js"></script>

  <!-- Sweet Alert 2 -->
  <script src="/template/general/vendors/sweetAlert/sweetalert2.all.min.js"></script>
  <!-- Search-select -->
  <script src="/template/general/vendors/search-select/bootstrap-select.min.js"></script>
  <link rel="stylesheet" href="/template/general/vendors/search-select/bootstrap-select.css">

  
</body>

<style lang="css">
    body{
        background-color: white;
        color: black;
    }
</style>