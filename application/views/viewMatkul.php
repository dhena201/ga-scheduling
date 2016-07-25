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
                <button class="btn btn-success" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>
                <br/>
                <br/>
                <table id="table" class="table table-striped table-bordered table-hover table-green" width="100%">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Program Studi</th>
                            <th style="width:110px;;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
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
    table = $('#table').DataTable({
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('mata_kuliah/ajax_list')?>",
            "type": "POST"
        },
        "columns" :[
            {"data" : "kd_kuliah"},
            {"data" : "nama_kuliah"},
            {"data" : "sks"},
            {"data" : "semester"},
            {"data" : "nama_prodi"},
            {"data":"id",render:function(data){
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
 
});
 
function add_data()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
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
        url : "<?php echo base_url('mata_kuliah/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id_kuliah);
            $('[name="kd_kuliah"]').val(data.kd_kuliah);
            $('[name="nama_kuliah"]').val(data.nama_kuliah);
            $('[name="sks"]').val(data.sks);
            $('[name="semester"]').val(data.semester);
            $('[name="id_prodi"]').val(data.id_prodi);
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
        url = "<?php echo base_url('mata_kuliah/ajax_add')?>";
    } else if(save_method == 'update'){
        url = "<?php echo base_url('mata_kuliah/ajax_update')?>";
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
            url : "<?php echo base_url('mata_kuliah/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Form Mata Kuliah</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Mata Kuliah</label>
                            <div class="col-md-9">
                                <input name="kd_kuliah" placeholder="Kode Mata Kuliah" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Mata Kuliah</label>
                            <div class="col-md-9">
                                <input name="nama_kuliah" placeholder="Nama Mata Kuliah" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah SKS</label>
                            <div class="col-md-9">
                                <select name="sks" class="form-control">
                                    <option value="">--Pilih Jumlah SKS--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Semester</label>
                            <div class="col-md-9">
                                <select name="semester" class="form-control">
                                    <option value="">--Pilih Semester--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Program Studi</label>
                            <div class="col-md-9">
                                <select name="id_prodi" class="form-control">
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