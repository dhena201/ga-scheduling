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
                </div>
                </div>
                <br>
                <table id="example-table" class="table table-striped table-bordered table-hover table-green" width="100%">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Program Studi</th>
                            <th>Kelas</th>
                            <th>Kapasitas</th>
                            <th>Ruang</th>
                            <th>Hari</th>
                            <th>Jam</th>
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
    ajax_list(0);
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
});

function ajax_list(thnajar){
    if(table){
        table.destroy();
    }
    table = $('#example-table').DataTable({

    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo base_url('jadwal/ajax_list')?>/"+thnajar,
        "type": "POST"
    },
    "columns" :[
        {"data" : "nama_kuliah"},
        {"data" : "nama_dosen"},
        {"data" : "nama_prodi"},
        {"data" : "kelas"},
        {"data" : "kapasitas"},
        {"data" : "nama_ruang"},
        {"data" : "hari"},
        {"data" : "jam"},
        {"data":"id_jadwal",render:function(data){
            var btn = "<a class='btn btn-sm btn-primary' href='javascript:void()' title='Edit' onclick='edit_data("+data+")'><i class='fa fa-edit'></i></a>&nbsp&nbsp<a class='btn btn-sm btn-danger' href='javascript:void()' title='Hapus' onclick='delete_data("+data+")'><i class='fa fa-trash-o'></i></a>";
            return btn;
        }}
    ],
    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ -1 ], //last column
        "orderable": false, //set not orderable
    },
    ],

    });
}

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
        url : "<?php echo base_url('jadwal/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id_jadwal);
            $('[name="thnajar"]').val(data.thn_ajar);
            $('[name="id_kelas"]').val(data.id_kelas);
            $('[name="nama_prodi"]').val(data.nama_prodi);
            $('[name="nama_kuliah"]').val(data.nama_kuliah);            
            $('[name="nama_dosen"]').val(data.nama_dosen);
            $('[name="kapasitas"]').val(data.kapasitas);
            $('[name="ruang"]').val(data.id_ruang);
            $('[name="hari"]').val(data.hari);
            $('[name="jam"]').val(data.jam);
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
 
function delete_data(id)
{
    if(confirm('Apakah Anda Yakin Menghapus Data Ini?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('jadwal/ajax_delete')?>/"+id,
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
                            <input name="nama_prodi" type="text" class="form-control" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Mata Kuliah</label>
                        <div class="col-md-9">
                            <input name="nama_kuliah" type="text" class="form-control" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Dosen</label>
                        <div class="col-md-9">
                            <input name="nama_dosen" type="text" class="form-control" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kapasitas Kelas</label>
                        <div class="col-md-9">
                            <input name="kapasitas" type="number" class="form-control" readonly>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Ruangan</label>
                        <div class="col-md-9">
                            <select name="ruang" class="form-control">
                                <?php foreach($ruang as $row){
                                    echo "<option value='$row[id_ruang]'>$row[nama_ruang]</option>";
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