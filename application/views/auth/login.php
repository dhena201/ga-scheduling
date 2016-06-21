<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SPKO</title>

    <!-- GLOBAL STYLES -->
    <link href="<?php echo base_url('asset/css/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <link href="<?php echo  base_url('asset/icons/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">

    <!-- PAGE LEVEL PLUGIN STYLES -->
    <!-- THEME STYLES -->
    <link href="<?php echo base_url('asset/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/css/plugins.css'); ?>" rel="stylesheet">

    <!-- THEME DEMO STYLES -->
    <link href="<?php echo base_url('asset/css/demo.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('asset/css/plugins/iCheck/square/blue.css') ?>">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-banner text-center">
                    <h1><i class="fa fa-gears"></i> SPKO</h1>
                </div>
                <div class="portlet portlet-green">
                    <div class="portlet-heading login-heading">
                        <div class="portlet-title">
                            <h4><strong>Login</strong>
                            </h4>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <?php echo form_open("auth/login");?>
                            <fieldset>
                                <div class="form-group">
                                    <?php echo form_input($identity, '', 'class="form-control" placeholder="Username"');?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_input($password, '', 'type="password" class="form-control" placeholder="Password"');?>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox icheck" style="padding-left:0">
                                        <label>
                                          <?php echo form_checkbox('remember', '1', FALSE);?>
                                          <?php echo 'Remember Me';?>
                                          <!--<?php echo lang('login_remember_label', 'remember');?>-->
                                        </label>
                                    </div>
                                </div>
                                <div id="infoMessage" style="color:red"><?php echo $message;?></div>
                                <br>
                                <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-lg btn-green btn-block"');?>
               
                            </fieldset>
                            <br>
                            <p class="small">
                                <a href="<?php echo base_url('auth/forgot_password')?>">Lupa Password?</a>
                            </p>
                            
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('asset/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/bootstrap/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?= base_url('asset/js/plugins/iCheck/icheck.min.js') ?>"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    <!-- HISRC Retina Images -->
    <script src="<?php echo base_url('asset/js/plugins/hisrc/hisrc.js'); ?>"></script>

    <!-- PAGE LEVEL PLUGIN SCRIPTS -->

    <!-- THEME SCRIPTS -->
    <script src="<?php echo base_url('asset/js/flex.js'); ?>"></script>
</body>

</html>
