<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Flex Admin - Responsive Admin Theme</title>

    <!-- GLOBAL STYLES -->
    <link href="<?php echo base_url('asset/css/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <link href="<?php echo  base_url('asset/icons/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">

    <!-- PAGE LEVEL PLUGIN STYLES -->
    <!-- THEME STYLES -->
    <link href="<?php echo base_url('asset/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/css/plugins.css'); ?>" rel="stylesheet">

    <!-- THEME DEMO STYLES -->
    <link href="<?php echo base_url('asset/css/demo.css'); ?>" rel="stylesheet">

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
                            <h4><?php echo lang('forgot_password_heading');?></h4>
                            
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
                        <?php echo form_open("auth/forgot_password");?>
                            <fieldset>
                                <div class="form-group">
                                    <p>
                                    <label for="identity">Username</label> <br />
                                    <?php echo form_input($identity);?>
                                    </p>
                                </div>
                                <div id="infoMessage" style="color:red"><?php echo $message;?></div>
                                <br>
                               <?php echo form_submit('submit', lang('forgot_password_submit_btn'));?>
                            
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
    <!-- HISRC Retina Images -->
    <script src="<?php echo base_url('asset/js/plugins/hisrc/hisrc.js'); ?>"></script>

    <!-- PAGE LEVEL PLUGIN SCRIPTS -->

    <!-- THEME SCRIPTS -->
    <script src="<?php echo base_url('asset/js/flex.js'); ?>"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</body>

</html>
