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
    
    <script src="<?php echo base_url('asset/js/plugins/bootstrap/bootstrap.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('asset/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/popupoverlay/jquery.popupoverlay.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/popupoverlay/defaults.js'); ?>"></script>
    <!-- HISRC Retina Images -->
    <script src="<?php echo base_url('asset/js/plugins/hisrc/hisrc.js'); ?>"></script>
    <!-- Logout Notification Box -->
    <div id="logout">
        <?php $this->load->view('logout');?>
    </div>
    <!-- /#logout -->
    <!-- Logout Notification jQuery -->
    <script src="<?php echo base_url('asset/js/plugins/popupoverlay/logout.js'); ?>"></script>
    <!-- PAGE LEVEL PLUGIN SCRIPTS -->
    
    <!-- THEME SCRIPTS -->
    
    <script src="<?php echo base_url('asset/js/flex.js'); ?>"></script>


</body>

</html>
