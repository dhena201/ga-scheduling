<!-- begin BASIC TABLES MAIN ROW -->
<div class="row">

<!-- Basic Responsive Table -->
<div class="col-lg-12">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Data Mata Kuliah</h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($matakuliah as $row){
                    ?>
                        <tr>
                            <td><?php echo $row['nama_kuliah']; ?></td>
                            <td><?php echo $row['sks']; ?></td>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['nama_prodi']; ?></td>
                            <td>
                                <a href=""><i class="fa fa-edit" data-toggle="modal" data-target="#flexModal"></i></a>&nbsp
                                <a href="" onclick="return confirm('Anda Yakin Menghapus Data ini?')"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <!-- Flex Modal -->
                    
                    <!-- /.modal -->
                </table>
            </div>
        </div>
    </div>
    <!-- /.portlet -->
</div>
<!-- /.col-lg-6 -->
<div class="modal modal-flex fade" id="flexModal" tabindex="-1" role="dialog" aria-labelledby="flexModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="flexModalLabel">Flex Admin Styled Modal</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-green">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>