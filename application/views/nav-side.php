<div class="navbar-collapse sidebar-collapse collapse">
    <ul id="side" class="nav navbar-nav side-nav">
        <!-- begin SIDE NAV USER PANEL -->
        <li class="side-user hidden-xs">
            <img class="img-circle" src="<?php echo base_url('asset/images/profile-pic.jpg'); ?>"  widht="150">
            <p class="welcome">
                <i class="fa fa-key"></i> Logged in as
            </p>
            <p class="name tooltip-sidebar-logout">
                
                <span class="last-name">Administrator</span> <a style="color: inherit" class="logout_open" href="#logout" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-sign-out"></i></a>
            </p>
            <div class="clearfix"></div>
        </li>
        <!-- end SIDE NAV USER PANEL -->
        <!-- begin SIDE NAV SEARCH -->
        <li class="nav-search">
            <form role="form">
                <input type="search" class="form-control" placeholder="Search...">
                <button class="btn">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </li>
        <!-- end SIDE NAV SEARCH -->
        <!-- begin DASHBOARD LINK -->
        <li>
            <a class="active" href="<?php echo base_url(); ?>">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
        <!-- end DASHBOARD LINK -->
        <!-- begin DOSEN DROPDOWN -->
        <li>
            <a href="<?php echo base_url('dosen'); ?>">
                <i class="fa fa-users"></i> Dosen
            </a>
        </li>
        <!-- end DOSEN LINK -->
        <!-- begin MATA KULIAH DROPDOWN -->
        <li>
            <a href="<?php echo base_url('mata-kuliah'); ?>">
                <i class="fa fa-book"></i> Mata Kuliah
            </a>
        </li>
        <!-- end MATA KULIAH LINK -->
        <!-- begin PROGRAM STUDI DROPDOWN -->
        <li>
            <a href="<?php echo base_url('program-studi'); ?>">
                <i class="fa fa-thumb-tack"></i> Program Studi
            </a>
        </li>
        <!-- end PROGRAM STUDI LINK -->
        <!-- begin RUANG DROPDOWN -->
        <li>
            <a href="<?php echo base_url('ruang'); ?>">
                <i class="fa fa-square-o"></i> Ruang
            </a>
        </li>
        <!-- end RUANG LINK -->
        <!-- begin KELAS DROPDOWN -->
        <li>
            <a href="<?php echo base_url('kelas'); ?>">
                <i class="fa fa-square"></i> Kelas
            </a>
        </li>
        <!-- end KELAS LINK -->
        <!-- begin JADWAL DROPDOWN -->
        <li class="panel">
            <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#tables">
                <i class="fa fa-table"></i> Jadwal <i class="fa fa-caret-down"></i>
            </a>
            <ul class="collapse nav" id="tables">
                <li>
                    <a href="<?php echo base_url('jadwal');?>">
                        <i class="fa fa-angle-double-right"></i> Buat Jadwal
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('jadwal');?>">
                        <i class="fa fa-angle-double-right"></i> Lihat Jadwal
                    </a>
                </li>
            </ul>
        </li>
        <!-- end JADWAL DROPDOWN -->
    </ul>
    <!-- /.side-nav -->
</div>
<!-- /.navbar-collapse -->