<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('head'); ?>
</head>

<body>

    <div id="wrapper">

        <!-- begin TOP NAVIGATION -->
        <nav class="navbar-top" role="navigation">
            <?php $this->load->view('nav-top'); ?>
        </nav>
        <!-- /.navbar-top -->
        <!-- end TOP NAVIGATION -->

        <!-- begin SIDE NAVIGATION -->
        <nav class="navbar-side" role="navigation">
            <?php $this->load->view('nav-side'); ?>
        </nav>
        <!-- /.navbar-side -->
        <!-- end SIDE NAVIGATION -->

        <!-- begin MAIN PAGE CONTENT -->
        <div id="page-wrapper">
            <div class="page-content">
                <!-- begin PAGE TITLE ROW -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>
                                <?php echo $breadcrumb; ?>
                                <small><?php if($subtitle)echo $subtitle; ?></small>
                            </h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url(); ?>">Dashboard</a>
                                </li>
                                <li class="active"><?php echo $breadcrumb; ?></li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- end PAGE TITLE ROW -->
                <?php $this->load->view($main_view); ?>
            </div>
        </div>
        <!-- /#page-wrapper -->
        <!-- end MAIN PAGE CONTENT -->

    </div>
    <!-- /#wrapper -->

    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('asset/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/bootstrap/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/popupoverlay/jquery.popupoverlay.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/popupoverlay/defaults.js'); ?>"></script>
    <!-- Logout Notification Box -->
    <div id="logout">
        <?php $this->load->view('logout');?>
    </div>
    <!-- /#logout -->
    <!-- Logout Notification jQuery -->
    <script src="<?php echo base_url('asset/js/plugins/popupoverlay/logout.js'); ?>"></script>
    <!-- HISRC Retina Images -->
    <script src="<?php echo base_url('asset/js/plugins/hisrc/hisrc.js'); ?>"></script>

    <!-- PAGE LEVEL PLUGIN SCRIPTS -->
    <!-- HubSpot Messenger -->
    <script src="<?php echo base_url('asset/js/plugins/messenger/messenger.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/messenger/messenger-theme-flat.js'); ?>"></script>
    <!-- Date Range Picker -->
    <script src="<?php echo base_url('asset/js/plugins/daterangepicker/moment.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- Morris Charts -->
    <script src="<?php echo base_url('asset/js/plugins/morris/raphael-2.1.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/morris/morris.js'); ?>"></script>
    <!-- Flot Charts -->
    <script src="<?php echo base_url('asset/js/plugins/flot/jquery.flot.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/flot/jquery.flot.resize.js'); ?>"></script>
    <!-- Sparkline Charts -->
    <script src="<?php echo base_url('asset/js/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
    <!-- Moment.js -->
    <script src="<?php echo base_url('asset/js/plugins/moment/moment.min.js'); ?>"></script>
    <!-- jQuery Vector Map -->
    <script src="<?php echo base_url('asset/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/jvectormap/maps/jquery-jvectormap-world-mill-en.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/demo/map-demo-data.js'); ?>"></script>
    <!-- Easy Pie Chart -->
    <script src="<?php echo base_url('asset/js/plugins/easypiechart/jquery.easypiechart.min.js'); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url('asset/js/plugins/datatables/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/datatables/datatables-bs3.js'); ?>"></script>

    <!-- THEME SCRIPTS -->

    <script src="<?php echo base_url('asset/js/flex.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/demo/dashboard-demo.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/demo/advanced-tables-demo.js');?>"></script>

</body>

</html>
