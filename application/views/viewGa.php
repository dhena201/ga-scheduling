<script>
function run_server_ga(){
  console.log("Calling Server looking for JSON in ");

	if (!!window.EventSource) {
 
  var source = new EventSource("<?php echo base_url('GA1');?>");
 
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
    for (var i = 0; i < 18; i++) {
      $('#h'+i).text(data.gen3[i]);
      $('#j'+i).text(data.gen2[i]);
      $('#r'+i).text(data.gen1[i]);
    };      
		 if (data.done==true)
			source.close();
		
}, false);

source.onerror = function(e) {
  $('#message').html("EventSource failed.");
  source.close();
};

} else {
  $('#message').html("<strong>Sorry your Browser doesn't support SERVER SIDE Events , needed to stream the live results.</strong>-<br>Supported browsers see here: <a href='http://caniuse.com/#feat=eventsource'>http://caniuse.com/</a> ");
}

}
  
$(document).ready(function() {
  console.log("document.ready");

// When any <submit > button  is clicked 
 $('#btnRun').click( function() { 
   run_server_ga(); //lets go to the server and look for this string
    return false; // keeps the page form  not refreshing 
  }); //end of event handler

 });  //end document.ready
 
</script>
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
                <select id="thn_ajar">
                    <option value="0">--Pilih Tahun Ajaran--</option>
                    <?php
                        foreach ($thn_ajar as $row) {
                             echo "<option value='$row[thn_ajar]'>$row[thn_ajar]</option>";
                         } 
                    ?>
                </select>
                <form id="form1" >
                KLik Untuk Memulai Pembuatan Jadwal : <input id="btnRun" type="submit" value="Run GA"/><br>
                <br/>
                Generations:<span id="generation"  class="med_text"> </span> /
                (stagnant: <span id="stagnant"  class="med_text"> </span>) /
                Fitness value: <span id="best_fittest_value"  class="med_text">  </span> /
                Elapsed Time: <span id="elapsed"  class="med_text"> </span>
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
                            <th style="width:110px;">Aksi</th>
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