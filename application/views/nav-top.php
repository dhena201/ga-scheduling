<!-- begin BRAND HEADING -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
        <i class="fa fa-bars"></i> Menu
    </button>
    <div class="navbar-brand">
        <a href="<?php echo base_url(); ?>">
            <!-- <img src="<?php echo base_url('asset/images/admin-logo@1x.png'); ?>" class="img-responsive" alt=""> -->
        </a>
    </div>
</div>
<!-- end BRAND HEADING -->

<div class="nav-top">

    <!-- begin LEFT SIDE WIDGETS -->
    <ul class="nav navbar-left">
        <li class="tooltip-sidebar-toggle">
            <a href="#" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Sidebar Toggle">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <!-- You may add more widgets here using <li> -->
    </ul>
    <!-- end LEFT SIDE WIDGETS -->

    <!-- begin MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->
    <ul class="nav navbar-right">

        <!-- begin MESSAGES DROPDOWN -->
        <li class="dropdown">
            
            <!-- /.dropdown-menu -->
        </li>
        <!-- /.dropdown -->
        <!-- end MESSAGES DROPDOWN -->

        <!-- begin ALERTS DROPDOWN -->
        <li class="dropdown">
            
            <!-- /.dropdown-menu -->
        </li>
        <!-- /.dropdown -->
        <!-- end ALERTS DROPDOWN -->

        <!-- begin TASKS DROPDOWN -->
        <li class="dropdown">
            
            <!-- /.dropdown-menu -->
        </li>
        <!-- /.dropdown -->
        <!-- end TASKS DROPDOWN -->

        <!-- begin USER ACTIONS DROPDOWN -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="<?= base_urL('profil')?>">
                        <i class="fa fa-user"></i> Profil
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="logout_open" href="<?php echo base_url('auth/logout');?>">
                        <i class="fa fa-sign-out"></i> Logout
                        <strong><?= $this->session->userdata('identity');?></strong>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-menu -->
        </li>
        <!-- /.dropdown -->
        <!-- end USER ACTIONS DROPDOWN -->

    </ul>
    <!-- /.nav -->
    <!-- end MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->

</div>
<!-- /.nav-top -->
