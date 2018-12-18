<script src="<?php echo base_url('/asset/js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('/asset/js/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('/asset/js/plugins/datatables/extensions/Buttons/js/buttons.print.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('/asset/js/plugins/pdfmake.min.js')?>" type="text/javascript"></script>

<!-- begin BASIC TABLES MAIN ROW -->
<div class="row">

<!-- Basic Responsive Table -->
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Data Jadwal</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="row form">
                <div class="form-group">
                    <label class="control-label col-md-12">Pilih Tahun Ajar</label>
                    <div class="col-md-3">
                        <select name="thn" id="thn_ajar" class="form-control">
                            <option value="0">--Pilih Tahun Ajaran--</option>
                            <?php
                                foreach ($thn_ajar as $row) {
                                     echo "<option value='$row[thn_ajar]'>$row[thn_ajar]</option>";
                                 } 
                            ?>
                        </select>
                    </div>
                    <?php if(!$this->ion_auth->is_admin()): ?>
                    <div class="col-md-6">
                        <button class="btn btn-success" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <?php endif;?>
                </div>
                </div>
                <br>
                <table id="example-table" class="table table-striped table-bordered table-green table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Program Studi</th>
                            <th>Kelas</th>
                            <th>Kapasitas</th>
                            <th>Ruang</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <?php if(!$this->ion_auth->is_admin()):?>
                            <th style="width:110px;">Aksi</th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <!-- Flex Modal -->
                    
                    <!-- /.modal -->
                </table>
            </div>
        </div>
        <!-- /.portlet -->
    </div>
    <!-- /.col-lg-6 -->
</div>

<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
    ajax_list();
    $('#thn_ajar').change(function(){
        var thnajar = $('#thn_ajar').val();
        ajax_list(thnajar);        
    });

    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    //dependent dropdown
    $("#kategori").change(function(){
        $("#mk > option").remove();
        $("#mk").append("<option value=''>--Pilih Mata Kuliah--</option>");
        var id_kategori = $("#kategori").val();
        if(id_kategori){
            get_mk(id_kategori);
        }
        console.log(id_kategori);
        
        
    });
    $("#asdos").change(function(){
        $("#dosen > option").remove();
        $("#dosen").append("<option value=''>--Pilih Dosen Pengampu--</option>");
        var id = $("#asdos").val();
        if(id){
            get_dosen(id);
        }
    });
    $('#mk').change(function(){
        var id = $("#mk").val();
        if(id){
            get_kelas(id);
        }
    });
});
function get_mk(id,id_kuliah){
    $.ajax({
        url : "<?php echo base_url('kelas/ajax_get_mk/')?>/" + id,
        type : "GET",
        dataType : "JSON",
        success: function(data){
            $.each(data, function(i, data){
                $("#mk").append("<option value='"+data.id_kuliah+"'>"+data.kd_kuliah+"   "+data.nama_kuliah+"</option>");
            });
            if(id_kuliah){
                $('#mk').val(id_kuliah);
            }
        },
         error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function get_dosen(id,id_dosen){
    $.ajax({
        url : "<?php echo base_url('kelas/ajax_get_dosen/')?>/" + id,
        type : "GET",
        dataType : "JSON",
        success: function(data){
            $.each(data, function(i, data){
                $("#dosen").append("<option value='"+data.id_dosen+"'>"+data.nama_dosen+"</option>");
                console.log(data.id_dosen);
            });
            if(id_dosen){
                $('#dosen').val(id_dosen);
            }
        },
         error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function get_kelas(id){
    $.ajax({
        url : "<?php echo base_url('kelas/ajax_get_kelas/')?>/" + id,
        type : "GET",
        dataType : "JSON",
        success: function(data){
            $("#kelas").val(data);
        },
         error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function ajax_list(thnajar){
    if(table){
        table.destroy();
    }
    table = $('#example-table').DataTable({

    // "processing": true, //Feature control the processing indicator.
    // "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo base_url('jadwal/ajax_list')?>",
        "type": "GET",
        "data": {"thnajar":thnajar}
    },
    "columns" :[
        {"data" : "kd_kuliah"},
        {"data" : "nama_kuliah"},
        {"data" : "nama_dosen"},
        {"data" : "nama_prodi"},
        {"data" : "kelas"},
        {"data" : "kapasitas"},
        {"data" : "nama_ruang"},
        {"data" : "hari"},
        {"data" : "jam"}
        <?php if(!$this->ion_auth->is_admin()):?>
        ,{"data":"id_jadwal",render:function(data){
            var btn = "<a class='btn btn-sm btn-primary' href='javascript:void()' title='Edit' onclick='edit_data("+data+")'><i class='fa fa-edit'></i></a>&nbsp&nbsp<a class='btn btn-sm btn-danger' href='javascript:void()' title='Hapus' onclick='delete_this("+data+")'><i class='fa fa-trash-o'></i></a>";
            return btn;
        }}
        <?php endif; ?>
    ],
    //Set column definition initialisation properties.
    "columnDefs": [{   <?php if(!$this->ion_auth->is_admin()):?>
        "targets": [ -1 ], //last column
        <?php endif; ?>
        "orderable": false, //set not orderable
        },
    ],
    "dom":'Blfrtip',
    "buttons":[
        {   extend: 'print',
            title: 'Jadwal Kuliah Tahun Akademik '+thnajar,
            exportOptions: {
                columns: [0, 1, 2, 4, 5, 6, 7, 8]
            }
        },
    ],
    }
    
    );
}

function add_data()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('[name="id_prodi"]').attr('disabled',false);
    $('#mk').attr('disabled',false);
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title

}
 
function edit_data(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('jadwal/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            get_mk(data.id_prodi,data.id_kuliah);
            $('[name="id_prodi"]').val(data.id_prodi);
            $('#mk').val(data.id_kuliah);
            $('[name="id_prodi"]').attr('disabled',true);
            $('#mk').attr('disabled',true);
            $('[name="kelas"]').val(data.kelas);
            $('[name="id"]').val(data.id_jadwal);
            $('[name="thnajar"]').val(data.thn_ajar);
            $('[name="id_kelas"]').val(data.id_kelas);
            $('[name="kapasitas"]').val(data.kapasitas);
            $('[name="ruang"]').val(data.id_ruang);
            $('[name="hari"]').val(data.hari);
            $('[name="jam"]').val(data.jam);
            $.ajax({
                url : "<?php echo base_url('Dosen/ajax_edit/')?>/" + data.id_dosen,
                type: "GET",
                dataType: "JSON",
                success: function(dat)
                {
                    get_dosen(dat.id_prodi,dat.id_dosen);
                    $('[name="asal_prodi"]').val(dat.id_prodi);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Data'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(); //reload datatable ajax
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    // ajax adding data to database
    $.ajax({
        url : "<?php echo base_url('jadwal/ajax_update')?>",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
            console.log(data.status);
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}
function delete_this(id){
    $('#modalDelete').attr('onclick','delete_data('+id+')');
    $('#myModal').modal('show');
}
function delete_data(id)
{
    
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('jadwal/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#myModal').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    
}
 
</script>
<!-- Bootstrap modal -->
<div class="modal modal-flex fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Jadwal</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="thnajar">
                    <input type="hidden" value="" name="id_kelas">
                    <div class="form-group">
                        <label class="control-label col-md-3">Program Studi</label>
                        <div class="col-md-9">
                            <select id="kategori" name="id_prodi" class="form-control">
                                <option value="">--Pilih Program Studi--</option>
                                <?php foreach($prodi as $row){
                                if($row['nama_prodi']!="Non-Teknik") 
                                echo "<option value='$row[id_prodi]'>$row[nama_prodi]</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Mata Kuliah</label>
                        <div class="col-md-9">
                            <select id="mk" name="id_kuliah" class="form-control">
                                <option value="">--Pilih Mata Kuliah--</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Dosen</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                <select id="asdos" name="asal_prodi" class="form-control">
                                    <option  value="">--Asal Dosen--</option>
                                    <?php foreach($prodi as $row){ 
                                        echo "<option value='$row[id_prodi]'>$row[nama_prodi]</option>";
                                        }
                                    ?>
                                </select>
                                </div>
                                <div class="col-md-7">
                                    <select id="dosen" name="id_dosen" class="form-control">
                                        <option value="">--Pilih Dosen Pengampu--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kelas</label>
                        <div class="col-md-9">
                            <input name="kelas" type="text" class="form-control" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kapasitas Kelas</label>
                        <div class="col-md-9">
                            <input name="kapasitas" type="number" class="form-control" >
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Ruangan</label>
                        <div class="col-md-9">
                            <select name="ruang" class="form-control">
                                <option value="">--Pilih Ruangan--</option>
                                <?php foreach($ruang as $row){
                                    echo "<option value='$row[id_ruang]'>$row[nama_ruang]  $row[kapasitas_ruang]</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Hari</label>
                        <div class="col-md-9">
                            <select name="hari" class="form-control">
                                <option value="">--Pilih Hari Kuliah--</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jum'at">Jum'at</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Jam</label>
                        <div class="col-md-9">
                            <input name="jam" class="form-control" type="text" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" id="24h"/>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->