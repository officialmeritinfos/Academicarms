<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $pagename;?> || <?php echo $Site_name;?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/css/default.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/css/flexslider.css">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans">
<script src="<?php echo base_url();?>assets/home/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo base_url();?>assets/home/js/jquery.flexslider.js"></script>
<script src="<?php echo base_url();?>assets/home/js/default.js"></script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="pagewidth">
  <div id="content">
    <section class="row">
      <div class="center">
        <h1>Welcome to <?php echo $Site_name;?></h1>
        <strong class="subHeading">Click any of the Button Below to proceed</strong>
        <div class="buttons"> <a href="<?php echo base_url();?>teachers" class="btn btnGreen"><span>Teacher Login</span></a> <span><em>or</em></span> <a href="<?php echo base_url();?>checkresult" class="btn btnBlue"><span>Check Result</span></a> </div>
      </div>
    </section>
    <section id="contactUs" class="row grey">
      <div class="center">
        <h1>Contact Us</h1>
        <strong class="subHeading">Are You Facing any issue, Contact school</strong>
        <div class="columns">
            <form action="#" class="form">
              <fieldset>
                <h2>Feedback form</h2>
                <div class="formRow">
                  <div class="textField">
                    <input type="text" placeholder="Your name ...">
                  </div>
                </div>
                <div class="formRow">
                  <div class="textField">
                    <input type="text" placeholder="Username">
                  </div>
                </div>
                <div class="formRow">
                  <div class="textField">
                    <input type="text" placeholder="Email">
                  </div>
                </div>
                <div class="formRow">
                  <div class="textField">
                    <textarea cols="20" rows="4" placeholder="Your Message ..."></textarea>
                  </div>
                </div>
                <div class="formRow">
                  <button class="btnSmall btn submit right"> <span>Send Message</span> </button>
                </div>
              </fieldset>
            </form>
        </div>
      </div>
    </section>
  </div>
  <footer id="footer" align="center">
    <div class="center"><p><?php echo $general_settings->row()->footer_text;?></p></div>
  </footer>
</div>
</body>
</html>