<script>
$(document).ready( function(){
$('#infoMessage').hide();
});
function edit_data()
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Ubah Data'); // Set title to Bootstrap modal title
    
}
function edit_pass()
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_password').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Ubah Password'); // Set title to Bootstrap modal title
    
}
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    
    var val = $('#idform').val();
    var url = "<?php echo base_url('user/ajax_update/')?>/"+val;
    
 
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
                $('[name="password"]').parent().prev().text('Password');
                if(data.message){
                    console.log(data.message);
                    $('#msg').html(data.message);
                    $('#infoMessage').show();
                }
            }
            else
            {
                if(data.inputerror){
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                
                if(data.message){
                    console.log(data.message);
                    $('#msg').html(data.message);
                    $('#infoMessage').show();
                }
                
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
</script>
<!-- begin BASIC TABLES MAIN ROW -->
<div class="row">

<!-- Basic Responsive Table -->
<div class="col-lg-12">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Profil <?= $this->session->userdata['identity']?></h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">
            <div class="col-lg-2">
                <img src="<?= base_url('asset/images/profile-pic.jpg')?>">
                <br/>
                <br/>
                <button class="btn col-md-12" onclick="edit_data()"><i class="fa fa-edit"></i> Ubah Profil</button>
                <br/>
                <br/>
                <button class="btn col-md-12" onclick="edit_pass()"><i class="fa fa-edit"></i> Ubah Password</button>
            </div>
            <div class="col-lg-10">
                <div class="callout callout-danger lead" id="infoMessage">
                    <p id="msg"></p>
                </div>
                <input id="idform" type="hidden" value="<?= $this->session->userdata['user_id']?>" name="id"/>
                <div class="form-group">
                    <label class="col-md-2">Username</label>
                    <div class="col-md-10">
                        <?php echo form_input($identity,'','class="form-control" disabled');?>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">Nama User</label>
                    <div class="col-md-10">
                        <?php echo form_input($name, '', 'class="form-control"');?>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">Email</label>
                    <div class="col-md-10">
                        <?php echo form_input($email, '', 'class="form-control"');?>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div> 
        <div class="portlet-footer">
            
        </div>          
    </div>
    <!-- /.portlet -->
</div>

<!-- Bootstrap modal -->
<div class="modal modal-flex fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="callout callout-danger lead" id="infoMessage">
                        <p id="msg"></p>
                    </div>
                    <input id="idform" type="hidden" value="<?= $this->session->userdata['user_id']?>" name="id"/>
                    <div class="form-group">
                        <label class="col-md-2">Username</label>
                        <div class="col-md-10">
                            <?php echo form_input($identity,'','class="form-control" disabled');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Nama User</label>
                        <div class="col-md-10">
                            <?php echo form_input($name, '', 'class="form-control"');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Email</label>
                        <div class="col-md-10">
                            <?php echo form_input($email, '', 'class="form-control"');?>
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

<!-- Bootstrap modal -->
<div class="modal modal-flex fade" id="modal_password" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2">Password Baru</label>
                        <div class="col-md-10">
                            <?php echo form_input($password, '', 'class="form-control"');?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2">Confirm Password</label>
                        <div class="col-md-10">
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