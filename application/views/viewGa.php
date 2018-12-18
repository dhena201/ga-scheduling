<div class="row">

<!-- Basic Responsive Table -->
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Buat Jadwal Kuliah</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="row form">
                    <div class="form-group">
                        <div class="col-md-3">
                            <select name="thn" id="thn_ajar" class="form-control">
                                <option value="0">--Pilih Tahun Ajaran--</option>
                                <?php
                                    $thn = intval("20".date('y'));
                                    $thnprev = intval($thn-1);
                                    $th = $thnprev.$thn."2";
                                    echo "<option value='$th'>$th</option>";
                                    for($i=0;$i<10;$i++){
                                      $thnini = intval($thn)+$i;
                                      $thnnex = intval($thnini)+1;
                                      $thnajar = $thnini.$thnnex;
                                      for($j=1;$j<=2;$j++){
                                        $thnajaran = $thnajar.$j;
                                        echo "<option value='$thnajaran'>$thnajaran</option>";
                                      }
                                    }
                                ?>
                            </select>
                        </div>
                        <span class="help-block"></span>
                        <div class="col-md-5">
                          <div class="row">
                            <div id="Run" class="col-md-3">
                              <button id="btnRun" class="btn btn-success">Buat Jadwal</button>
                            </div>
                            <div id="Reset" class="col-md-4">
                              <button id="btnReset" class="btn btn-success">Buat Ulang Jadwal</button>
                            </div>
                            <div id="SaveJadwal" class="col-md-4">
                              <button id="btnSaveJadwal" class="btn btn-success">Simpan Jadwal</button>
                            </div>
                          </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <div class="col-md-12" id="GA_stat">
                        <label>Generasi :</label> <span id="generation"  class="med_text">0</span>
                        (stagnant : <span id="stagnant"  class="med_text">0</span> )
                        <label>NIlai Fitness Terbaik:</label> <span id="best_fittest_value"  class="med_text">0</span>
                        <label>Waktu Proses :</label> <span id="elapsed"  class="med_text">0</span>
                        <br/>
                        <span id="message"> </span>
                    </div>
                </div>
                
                <br/>
                <table id="example-table" class="table table-striped table-bordered table-hover table-green" width="100%">
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
                            <th style="min-width:60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                     <!--<?php
                      // $i=0;
                      // foreach ($datakelas as $datakelas) {
                      //   echo "<tr>
                      //   <td>$datakelas[nama_kuliah]</td>
                      //   <td>$datakelas[nama_dosen]</td>
                      //   <td><span id='r$i'> </span></td>
                      //   <td><span id='h$i'> </span></td>
                      //   <td><span id='j$i'> </span></td>
                      //   <td><span id='s$i'> </span></td>
                      //   </tr>";
                      //   $i++;
                      // }
                    ?>-->
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
    ajax_list();
    console.log("document.ready");
    $('#GA_stat').hide();
    $('#Reset').hide();
    $('#btnSaveJadwal').attr('disabled',true);
    // When any <submit > button  is clicked 
    $('#btnRun').click( function() {
      $('#btnSaveJadwal').attr('disabled',true);
      var thnajar = $('#thn_ajar').val();
      console.log(thnajar);
      if(thnajar!=0){
        if(table){
          table.destroy();
        }
        ajax_list(thnajar);
        $('#thn_ajar').attr('disabled',true);
        $('#GA_stat').show();
        $('#btnRun').text('Running..');
        $('#btnRun').attr('disabled',true);
        run_server_ga(thnajar); //lets go to the server and look for this string
        return false; // keeps the page form  not refreshing  
      } else{
        alert("Tahun Ajar Belum Dipilih!");
        return false;
      }
      
    }); 

    $('#btnSaveJadwal').click( function(){
      var thnajar = $('#thn_ajar').val();
      savetmp(thnajar);
    });
    $('#btnReset').click( function(){
      if(table){
          table.destroy();
          ajax_list();
      }
      $('#GA_stat').hide();
      $('#btnSaveJadwal').attr('disabled',true);
      $('#Run').show();
      $('#thn_ajar').attr('disabled',false);
      $('#Reset').hide();
    });
    $("#asdos").change(function(){
        $("#dosen > option").remove();
        $("#dosen").append("<option value=''>--Pilih Dosen Pengampu--</option>");
        var id = $("#asdos").val();
        if(id){
            get_dosen(id);
        }
    });

    //end of event handler

    // //set input/textarea/select event when change value, remove class error and remove text help block
    // $("input").change(function(){
    //     $(this).parent().parent().removeClass('has-error');
    //     $(this).next().empty();
    // });
    // $("textarea").change(function(){
    //     $(this).parent().parent().removeClass('has-error');
    //     $(this).next().empty();
    // });
    // $("select").change(function(){
    //     $(this).parent().parent().removeClass('has-error');
    //     $(this).next().empty();
    // });
    // //dependent dropdown
});


function run_server_ga(thnajar){
  console.log("Calling Server looking for JSON in ");

  if (!!window.EventSource) {
 
  var source = new EventSource("<?php echo base_url('GA/evolve/');?>/"+thnajar);
  source.addEventListener('update', function(e)
  {
    // console.log("Receiving JSON server side events");
   
    var data = JSON.parse(e.data);
    $('#best_individual').html(data.best_individual); // Clear various <spans>
    $('#best_fittest_value').text(data.best_fittest_value); //
    $('#generation').text(data.generation);
    $('#stagnant').text(data.stagnant);
    $('#max_fitness').text(data.max_fitness);
    $('#message').html(data.message);
    $('#elapsed').text(data.elapsed);
    if (data.done==true){
      $('#btnSaveJadwal').attr('disabled',false);
      $('#btnRun').text('Buat Jadwal');
      $('#btnRun').attr('disabled',false);
      $('#Run').hide();
      $('#Reset').show();
      source.close();
      reload_table();
    }
    
  }, false);
  source.addEventListener('update2', function(e)
  {
    // console.log("Receiving JSON server side events");
    reload_table();
  }, false);

  source.onerror = function(e) {
    $('#message').html("EventSource failed.");
    source.close();
  };

  } else {
    $('#message').html("<strong>Sorry your Browser doesn't support SERVER SIDE Events , needed to stream the live results.</strong>-<br>Supported browsers see here: <a href='http://caniuse.com/#feat=eventsource'>http://caniuse.com/</a> ");
  }

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
function ajax_list(thnajar){
     
    table = $('#example-table').DataTable({
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo base_url('Buat_jadwal/ajax_listtmp')?>",
          "type": "POST",
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
          {"data" : "jam"},
          {"data":"id_jadwal",render:function(data){
              var btn = "<a class='btn btn-sm btn-primary' href='javascript:void()' title='Edit' onclick='edit_data("+data+")'><i class='fa fa-edit'></i></a>";
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
        url : "<?php echo base_url('Buat_jadwal/ajax_edittmp/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="kelas"]').val(data.kelas);
            $('[name="id"]').val(data.id_jadwal);
            $('[name="thnajar"]').val(data.thn_ajar);
            $('[name="id_kelas"]').val(data.id_kelas);
            $('[name="nama_prodi"]').val(data.nama_prodi);
            $('[name="nama_kuliah"]').val(data.nama_kuliah);            
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
        url : "<?php echo base_url('Buat_jadwal/ajax_updatetmp')?>",
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
function savetmp(thnajar)
{
    $('#btnSaveJadwal').text('Menyimpan...'); //change button text
    $('#btnSaveJadwal').attr('disabled',true); //set button disable
    // ajax adding data to database
    $.ajax({
        url : "<?php echo base_url('Buat_jadwal/ajax_savetmp/')?>/"+thnajar,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            $('#btnSaveJadwal').text('Simpan Jadwal'); //change button text
            $('#btnSaveJadwal').attr('disabled',true); //set button enable
            console.log(data.status);
            alert("Berhasil Menyimpan Jadwal");

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveJadwal').text('Simpan Jadwal'); //change button text
            $('#btnSaveJadwal').attr('disabled',false); //set button enable
 
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
                            <input name="kelas" type="text" class="form-control" readonly="">
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