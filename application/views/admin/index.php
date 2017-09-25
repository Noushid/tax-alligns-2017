<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accounts & TaxAlliance -Dashboard</title>
    <!-- Bootstrap Styles-->
    <link href="<?php echo base_url();?>adm/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="<?php echo base_url();?>adm/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
<!--    <link href="--><?php //echo base_url();?><!--adm/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />-->
    <!-- Custom Styles-->
    <link href="<?php echo base_url();?>adm/assets/css/custom-styles.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>adm/assets/css/custom.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link rel="stylesheet" href="<?php echo base_url();?>adm/assets/js/Lightweight-Chart/cssCharts.css">



    <link href="<?php echo base_url();?>adm/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
<!--    <script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>-->
    <script src="//cdn.ckeditor.com/4.5.6/full-all/ckeditor.js"></script>
<!--    <script src="--><?php //echo base_url();?><!--adm/assets/js/ckeditor.js"></script>-->
    <!-- Angular Module-->
    <script src="<?php echo base_url();?>adm/assets/js/angular-bootstrap.js"></script>
    <script src="<?php echo base_url();?>adm/assets/js/angularApp.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>ng-ckeditor.css">
    <!-- Angular Module end -->

    <!-- Light box start start-->
    <link rel="stylesheet" href="<?php echo base_url();?>adm/assets/css/app.min.css">
    <script src="<?php echo base_url();?>adm/assets/js/lightbox-plus-jquery.min.js"></script>
    <!-- Light box start end-->


</head>

<body ng-app="myApp" ng-controller="adminController">
<div id="wrapper">
    <nav class="navbar navbar-default top-navbar" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=""><strong>Accounts and tax</strong></a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="" aria-expanded="false">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo base_url('dashboard/#user-profile')?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('dashboard/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
        </ul>
    </nav>
    <!--/. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <?php echo dashboard_menu()?>
    </nav>
    <!-- /. NAV SIDE  -->

    <div id="page-wrapper">
    <div ng-view></div>
    <!-- /. PAGE WRAPPER  -->
    </div>
</div>

<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="<?php echo base_url();?>adm/assets/js/jquery-1.10.2.js"></script>
<!-- Bootstrap Js -->
<script src="<?php echo base_url();?>adm/assets/js/bootstrap.min.js"></script>

<!-- Metis Menu Js -->
<script src="<?php echo base_url();?>adm/assets/js/jquery.metisMenu.js"></script>
<!-- Morris Chart Js -->
<script src="<?php echo base_url();?>adm/assets/js/morris/raphael-2.1.0.min.js"></script>
<!--<script src="--><?php //echo base_url();?><!--adm/assets/js/morris/morris.js"></script>-->


<script src="<?php echo base_url();?>adm/assets/js/easypiechart.js"></script>
<script src="<?php echo base_url();?>adm/assets/js/easypiechart-data.js"></script>

<script src="<?php echo base_url();?>adm/assets/js/Lightweight-Chart/jquery.chart.js"></script>

<!-- Custom Js -->
<script src="<?php echo base_url();?>adm/assets/js/custom-scripts.js"></script>
<script src="<?php echo base_url();?>adm/assets/js/custom.js"></script>

<script>

</script>

</body>

</html>