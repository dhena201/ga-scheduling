<!-- begin BASIC TABLES MAIN ROW -->
<div class="row">

<!-- Basic Responsive Table -->
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Data Kelas</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <button class="btn btn-success" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>
                <br/>
                <br/>
                <table id="example-table" class="table table-striped table-bordered table-hover table-green" width="100%">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Kelas</th>
                            <th>Program Studi</th>
                            <th>Kapasitas</th>
                            <th style="width:110px;">Aksi</th>
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
 
    //datatables
    table = $('#example-table').DataTable({
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('kelas/ajax_list')?>",
            "type": "POST"
        },
        "columns" :[
            {"data" : "kd_kuliah"},
            {"data" : "nama_kuliah"},
            {"data" : "nama_dosen"},
            {"data" : "kelas"},
            {"data" : "nama_prodi"},
            {"data" : "kapasitas"},
            {"data":"id_kelas",render:function(data){
                var btn = "<a class='btn btn-sm btn-primary' href='javascript:void()' title='Edit' onclick='edit_data("+data+")'><i class='fa fa-edit'></i></a>&nbsp&nbsp<a class='btn btn-sm btn-danger' href='javascript:void()' title='Hapus' onclick='delete_this("+data+")'><i class='fa fa-trash-o'></i></a>";
                return btn;
            }
            }
        ],
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
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
function add_data()
{
    save_method = 'add';
    $("#mk > option").remove();
    $("#mk").append("<option value=''>--Pilih Mata Kuliah--</option>");
    $("#dosen > option").remove();
    $("#dosen").append("<option value=''>--Pilih Dosen Pengampu--</option>");
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title

}
 
function edit_data(id)
{
    save_method = 'update';
    $("#mk > option").remove();
    $("#mk").append("<option value=''>--Pilih Mata Kuliah--</option>");
    $("#dosen > option").remove();
    $("#dosen").append("<option value=''>--Pilih Dosen Pengampu--</option>");
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('kelas/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            get_mk(data.id_prodi,data.id_kuliah);
            get_dosen(data.id_prodi,data.id_dosen);
            $('[name="id"]').val(data.id_kelas);    
            $('[name="id_prodi"]').val(data.id_prodi);
            $('#mk').val(data.id_kuliah);
            $('[name="asal_prodi"]').val(data.id_prodi);
            $('[name="kelas"]').val(data.kelas);
            $('[name="kapasitas"]').val(data.kapasitas);
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
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo base_url('kelas/ajax_add')?>";
    } else if(save_method == 'update'){
        url = "<?php echo base_url('kelas/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
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
            url : "<?php echo base_url('kelas/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Form Kelas</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
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
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Mata Kuliah</label>
                            <div class="col-md-9">
                                <select id="mk" name="id_kuliah" class="form-control">
                                    <option value="">--Pilih Mata Kuliah--</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
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
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kelas</label>
                        <div class="col-md-9">
                            <input id="kelas" name="kelas" type="text" class="form-control" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kapasitas Kelas</label>
                        <div class="col-md-9">
                            <input name="kapasitas" placeholder="Kapasitas Kelas" type="number" class="form-control" min="0">
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