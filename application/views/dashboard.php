<!-- begin DASHBOARD CIRCLE TILES -->
<div class="row">
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('dosen');?>">
                <div class="circle-tile-heading dark-blue">
                    <i class="fa fa-users fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content dark-blue">
                <div class="circle-tile-description text-faded">
                    Dosen
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_dosen; ?>
                    <span id="sparklineA"></span>
                </div>
                <a href="<?php echo base_url('dosen');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('mata-kuliah');?>">
                <div class="circle-tile-heading green">
                    <i class="fa fa-book fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content green">
                <div class="circle-tile-description text-faded">
                    Mata Kuliah
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_matkul; ?>
                </div>
                <a href="<?php echo base_url('mata-kuliah');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('program-studi');?>">
                <div class="circle-tile-heading orange">
                    <i class="fa fa-thumb-tack fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content orange">
                <div class="circle-tile-description text-faded">
                    Program Studi
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_prodi; ?>
                </div>
                <a href="<?php echo base_url('program-studi');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('ruang');?>">
                <div class="circle-tile-heading blue">
                    <i class="fa fa-square-o fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content blue">
                <div class="circle-tile-description text-faded">
                    Ruang
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_ruang; ?>
                    <span id="sparklineB"></span>
                </div>
                <a href="<?php echo base_url('ruang');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('kelas');?>">
                <div class="circle-tile-heading red">
                    <i class="fa fa-square fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content red">
                <div class="circle-tile-description text-faded">
                    Kelas
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_kelas; ?>
                    <span id="sparklineC"></span>
                </div>
                <a href="<?php echo base_url('kelas');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('jadwal');?>">
                <div class="circle-tile-heading purple">
                    <i class="fa fa-table fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content purple">
                <div class="circle-tile-description text-faded">
                    Jadwal
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_jadwal; ?>
                    <span id="sparklineD"></span>
                </div>
                <a href="<?php echo base_url('jadwal');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- end DASHBOARD CIRCLE TILES -->
 <!-- end PAGE TITLE ROW -->

<div class="row">

<!-- Area Chart Example -->
<div class="col-lg-12">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Area Chart</h4>
            </div>
            <div class="portlet-widgets">
                <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                <span class="divider"></span>
                <a data-toggle="collapse" data-parent="#accordion" href="#areaChart"><i class="fa-chevron-down fa"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="areaChart" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div id="morris-chart-area"></div>
            </div>
        </div>
    </div>
</div>
<!-- /.col-lg-12 -->

<!-- Line Chart Example -->
<div class="col-lg-12">
    <div class="portlet portlet-green">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Line Chart</h4>
            </div>
            <div class="portlet-widgets">
                <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                <span class="divider"></span>
                <a data-toggle="collapse" data-parent="#accordion" href="#lineChart"><i class="fa fa-chevron-down"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="lineChart" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div id="morris-chart-line"></div>
            </div>
        </div>
    </div>
</div>
<!-- /.col-lg-12 -->

<!-- Bar Chart Example -->
<div class="col-lg-6">
    <div class="portlet portlet-blue">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Bar Chart</h4>
            </div>
            <div class="portlet-widgets">
                <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                <span class="divider"></span>
                <a data-toggle="collapse" data-parent="#accordion" href="#barChart"><i class="fa fa-chevron-down"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="barChart" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div id="morris-chart-bar"></div>
            </div>
        </div>
    </div>
</div>
<!-- /.col-lg-6 -->

<!-- Donut Chart Example -->
<div class="col-lg-6">
    <div class="portlet portlet-orange">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Donut Chart</h4>
            </div>
            <div class="portlet-widgets">
                <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                <span class="divider"></span>
                <a data-toggle="collapse" data-parent="#accordion" href="#donutChart"><i class="fa fa-chevron-down"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="donutChart" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="portlet-body">
                    <div id="morris-chart-donut"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.col-lg-6 -->

</div>
<!-- /.row -->
<!-- Morris Charts -->
<script src="<?php echo base_url('asset/js/plugins/morris/raphael-2.1.0.min.js');?>"></script>
<script src="<?php echo base_url('asset/js/plugins/morris/morris.js');?>"></script>
<!-- Morris Demo/Dummy Data -->
<script src="<?php echo base_url('asset/js/plugins/morris/morris-demo-data.js');?>"></script>
