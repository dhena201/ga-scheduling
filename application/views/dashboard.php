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
    <?php if($this->ion_auth->is_admin()):?>
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
    <?php endif; ?>
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
    <?php if($this->ion_auth->is_admin()):?>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="<?php echo base_url('user');?>">
                <div class="circle-tile-heading purple">
                    <i class="fa fa-user fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content purple">
                <div class="circle-tile-description text-faded">
                    Operator
                </div>
                <div class="circle-tile-number text-faded">
                    <?php echo $count_user; ?>
                    <span id="sparklineD"></span>
                </div>
                <a href="<?php echo base_url('user');?>" class="circle-tile-footer">Detail <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if(!$this->ion_auth->is_admin()):?>
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
    <?php endif;?>
</div>
<!-- end DASHBOARD CIRCLE TILES -->
 <!-- end PAGE TITLE ROW -->

<?php $this->load->view('viewjadwal');?>