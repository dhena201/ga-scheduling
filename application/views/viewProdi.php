<!-- begin BASIC TABLES MAIN ROW -->
<div class="row">

<!-- Basic Responsive Table -->
<div class="col-lg-12">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Data Program Studi</h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">
            <a class="btn btn-success" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</a>
            <a class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</a>
            <br/><br/>
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered table-hover table-green">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    /*$i=0;
                    foreach($prodi as $row){
                        $i++;
                    
                        <tr>
                            <td><?php echo $row['id_prodi']; ?></td>
                            <td><?php echo $row['nama_prodi']; ?></td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_data(<?php echo $row['id_prodi']?>)"><i class="fa fa-edit"></i></a>&nbsp
                                <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_data(<?php echo $row['id_prodi']?>)"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                      } */?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.portlet -->
</div>
<!-- /.col-lg-6 -->
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({
 
        // "processing": true, //Feature control the processing indicator.
        // "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('program_studi/ajax_list')?>",
            "type": "GET",
            'dataSrc' : 'data',
        },
        "columns":[
            {"data":"id"},
            {"data":"nama_prodi"},
            {"data":"id",render:function(data){
                var btn = "<a class='btn btn-sm btn-primary' href='javascript:void()' title='Edit' onclick='edit_data("+data+")'><i class='fa fa-edit'></i></a>&nbsp<a class='btn btn-sm btn-danger' href='javascript:void()' title='Hapus' onclick='delete_data("+data+")'><i class='fa fa-trash-o'></i></a>";
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
        url : "<?php echo base_url('program_studi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id_prodi);
            $('[name="nama_prodi"]').val(data.nama_prodi);
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
        url = "<?php echo base_url('program_studi/ajax_add')?>";
    } else if(save_method == 'update'){
        url = "<?php echo base_url('program_studi/ajax_update')?>";
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
 
function delete_data(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('program_studi/ajax_delete')?>/"+id,
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
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Dosen</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Program Studi</label>
                            <div class="col-md-9">
                                <input name="nama_prodi" placeholder="Nama Program Studi" class="form-control" type="text">
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