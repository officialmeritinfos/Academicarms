<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo "$Site_name";?> | <?php echo $pagename;?> </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/dashboard/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
          	<!--SHOWING FORM ERRORS -->
            <?php if (validation_errors()) {  ?>
                <div class="alert alert-danger alert-dismissable">
                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo validation_errors(); ?>
                </div>
            <?php } ?> 
            <!--//SHOWING ERRORS -->

            <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
            <?php if ($this->session->flashdata('message') != null) {  ?>                            
                <?php echo $this->session->flashdata('message'); ?>                                  
            <?php } ?>
            <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
            <?php echo form_open();?>
              <h1> <?php echo $pagename;?> </h1>
              <div>
                <input type="password" class="form-control" placeholder="Enter Password" name="password" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Reset</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                
                <div class="clearfix"></div>
                <br />

                <div>
                  <?php echo $general_settings->row()->footer_text;?>
                </div>
              </div>
            <?php echo form_close();?>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>