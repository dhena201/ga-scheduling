<div class="row">
    <div class="col-md-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Data Operator</h4>
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-header -->
            <div class="portlet-body">
                <button class="btn btn-success" onclick="add_data()"><i class="fa fa-plus"></i> Tambah Operator</button>
                <br/>
                <br/>
                <table id="example-table" class="table table-striped table-bordered table-hover table-green" width="100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th style="width:110px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div><!-- /.portlet-body -->
        </div><!-- /.box -->
    </div>
</div>

<div class="modal modal-flex fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                 <h3 id="myModalLabel">Delete Confirmation</h3>

            </div>
            <div class="modal-body">
                <h3><i class="fa fa-warning modal-icon"></i>&nbspAre you sure you want to delete the cover?
                    <br>This cannot be undone.</h3>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-danger"  id="modalDelete" >Delete</a>
              <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button> 
            </div>
        </div>
    </div>
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
            "url": "<?php echo base_url('user/ajax_list')?>",
            "type": "POST"
        },
        "columns" :[
            {"data" : "name"},
            {"data" : "username"},
            {"data" : "email"},
            {"data":"id",render:function(data){
                var btn = "<a class='btn btn-sm btn-primary' href='javascript:void()' title='Edit' onclick='edit_data("+data+")'><i class='fa fa-edit'></i></a>&nbsp&nbsp<a class='btn btn-sm btn-danger' href='javascript:void()' title='Hapus' onclick='delete_data("+data+")'><i class='fa fa-trash-o'></i></a>";
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
    $('#infoMessage').hide();
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
        url : "<?php echo base_url('user/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            
            $('[name="id"]').val(data.id);    
            $('[name="name"]').val(data.name);
            $('[name="identity"]').val(data.username);
            $('[name="email"]').val(data.email);
            $('[name="password"]').parent().prev().text('Ubah Password');
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
        url = "<?php echo base_url('user/ajax_add')?>";
    } else if(save_method == 'update'){
        var val = $('#idform').val();
        url = "<?php echo base_url('user/ajax_update/')?>/"+val;
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
                $('[name="password"]').parent().prev().text('Password');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
                $('#infoMessage').show();
                $('#infoMessage').html(data.message);
                
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data '+textStatus);
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}
 
function delete_data(id)
{
    if(confirm('Apakah Anda Yakin Menghapus Data Ini?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('user/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}
 
</script>
<script>
 $('.trash').click(function(){
    var id=$(this).data('id');
    $('#modalDelete').attr('href','auth/deactivate/'+id);
  })

     /*    $('#myModal').on('shown.bs.modal', function () {
  $('#modalAD').focus();
})*/
</script>
<div class="modal modal-flex fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form User</h3>
            </div>
            <div class="modal-body form">
                <div class="callout callout-danger lead" id="infoMessage">
                    <h4>Warning !</h4>
                    <p id="msg"></p>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <input id="idform" type="hidden" value="" name="id"/>
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama User</label>
                        <div class="col-md-9">
                            <?php echo form_input($name, '', 'class="form-control"');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Username</label>
                        <div class="col-md-9">
                            <?php echo form_input($identity,'','class="form-control"');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email</label>
                        <div class="col-md-9">
                            <?php echo form_input($email, '', 'class="form-control"');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Password</label>
                        <div class="col-md-9">
                            <?php echo form_input($password, '', 'class="form-control"');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Confirm Password</label>
                        <div class="col-md-9">
                            <?php echo form_input($password_confirm, '', 'class="form-control"');?>
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