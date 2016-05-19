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
                <label>Tahun Ajaran</label>
                <select id="thn_ajar" name="thnajar">
                    <option value="">--Pilih Tahun Ajaran--</option>
                    <?php
                        foreach ($thn_ajar as $row) {
                             echo "<option value='$row[thn_ajar]'>$row[thn_ajar]</option>";
                         } 
                    ?>
                </select>
                <form id="form1" >
                KLik Untuk Memulai Pembuatan Jadwal : <button id="btnRun" class="btn btn-success">Run GA</button>
                <br/>
                <label>Generasi :</label> <span id="generation"  class="med_text">0</span>
                (stagnant : <span id="stagnant"  class="med_text">0</span> )
                <label>NIlai Fitness :</label> <span id="best_fittest_value"  class="med_text">0</span>
                <label>Waktu Proses :</label> <span id="elapsed"  class="med_text">0</span>
                <br/>
                <span id="message"> </span>
                <br/>
                <br/>
                <table id="example-table" class="table table-striped table-bordered table-hover table-green" width="100%">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Ruang</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <!-- <th style="width:110px;">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                     <?php
                      $i=0;
                      foreach ($datakelas as $datakelas) {
                        echo "<tr>
                        <td>$datakelas[nama_kuliah]</td>
                        <td>$datakelas[nama_dosen]</td>
                        <td><span id='r$i'> </span></td>
                        <td><span id='h$i'> </span></td>
                        <td><span id='j$i'> </span></td>
                        <td><span id='s$i'> </span></td>
                        </tr>";
                        $i++;
                      }
                    ?>
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
    
    console.log("document.ready");
    // When any <submit > button  is clicked 
    $('#btnRun').click( function() {
      var thnajar = $('#thn_ajar').val();
      console.log(thnajar);
      if(thnajar){
        // ajax_list(thnajar);
        $('#btnRun').text('Running..');
        $('#btnRun').attr('disabled',true);
        run_server_ga(thnajar); //lets go to the server and look for this string
        return false; // keeps the page form  not refreshing  
      } else{
        alert("Tahun Ajar Belum Dipilih!");
        return false;
      }
      
    }); //end of event handler
 
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
    // reload_table();
    var data = JSON.parse(e.data);
    $('#best_individual').html(data.best_individual); // Clear various <spans>
    $('#best_fittest_value').text(data.best_fittest_value); //
    $('#generation').text(data.generation);
    $('#stagnant').text(data.stagnant);
    $('#max_fitness').text(data.max_fitness);
    $('#message').html(data.message);
    $('#elapsed').text(data.elapsed);
    for (var i = 0; i < 18; i++) {
      $('#h'+i).text(data.gen3[i]);
      $('#j'+i).text(data.gen2[i]);
      $('#r'+i).text(data.gen1[i]);
      $('#s'+i).text(data.stat[i]);
    };      
    if (data.done==true){
      $('#btnRun').text('Run GA');
      $('#btnRun').attr('disabled',false);
      source.close();
    }
      
    
  }, false);

  source.onerror = function(e) {
    $('#message').html("EventSource failed.");
    source.close();
  };

  } else {
    $('#message').html("<strong>Sorry your Browser doesn't support SERVER SIDE Events , needed to stream the live results.</strong>-<br>Supported browsers see here: <a href='http://caniuse.com/#feat=eventsource'>http://caniuse.com/</a> ");
  }

}

function ajax_list(thnajar){ 
    var table   
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
    return false;          
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