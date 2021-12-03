<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $pagename;?></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> <?php echo $pagename;?> </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>                            
                        <?php echo $this->session->flashdata('message'); ?>                                  
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Site Settings</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">General Settings</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Logo</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                          <?php echo form_open('admin/system_settings/site_settings','class="form-horizontal form-label-left input_mask"');?>
                            
                            <label for="fullname">Site Name* </label>
                            <input type="text" id="fullname" class="form-control input-lg" name="site_name" value="<?php echo htmlentities($general_settings->row()->Site_name);?>" />
                            <label for="email">Site Email* </label>
                            <input type="text" id="email" class="form-control input-lg" name="site_email" value="<?php echo htmlentities($general_settings->row()->Site_email);?>"/>
                            <label for="email">Site Shortname* <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Neccessary for Some automatic generations"></i></label>
                            <input type="text" id="email" class="form-control input-lg" name="site_shortname" value="<?php echo htmlentities($general_settings->row()->Site_shortname);?>"/>
                            <label for="email">Site Tags* <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Neccessary for Search Engine optimizations"></i></label>
                            <textarea id="email" class="form-control input-lg" name="site_tag" placeholder="Separate each tag with a comma"><?php echo htmlentities($general_settings->row()->Site_tag);?></textarea>
                            <label for="email">Footer Text*</label>
                            <textarea id="email" class="form-control input-lg" name="footer_text"><?php echo htmlentities($general_settings->row()->footer_text);?></textarea>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                          <?php echo form_open('admin/system_settings/general_settings','class="form-horizontal form-label-left input_mask"');?>
                            
                            <label for="fullname">Default Password* </label>
                            <input type="text" id="fullname" class="form-control input-lg" name="default_password" value="<?php echo htmlentities($general_settings->row()->Default_password);?>" />
                            <label for="email">Result Pin Lenght* </label>
                            <input type="number" id="email" class="form-control input-lg" name="resultpin" value="<?php echo htmlentities($general_settings->row()->Resultpin_length);?>"/>
                            <label for="email">Serial Number Length* </label>
                            <input type="number" id="email" class="form-control input-lg" name="serialnumber" value="<?php echo htmlentities($general_settings->row()->Serialpin_length);?>"/>
                            <label for="email">Result Pin Usage* </label>
                            <input type="number" id="email" class="form-control input-lg" name="pinusage" value="<?php echo htmlentities($general_settings->row()->Pin_usage);?>"/>
                            <label for="email">Teachers Can Add Students* </label>
                            <select id="email" class="form-control input-lg" name="teacher_student">
                              <option value="">Select</option>
                            <?php 
                              if ($general_settings->row()->Teacher_add_students==1):?>
                              <option value="1" selected="">Yes [Selected]</option>
                            <?php else:?>
                              <option value="2" selected="">No [Selected]</option>
                            <?php endif;?>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                            </select>
                            <label for="email">Teachers Can Add Result* </label>
                            <select id="email" class="form-control input-lg" name="teacher_result">
                              <option value="">Select</option>
                            <?php 
                              if ($general_settings->row()->Teacher_add_result==1):?>
                              <option value="1" selected="">Yes [Selected]</option>
                            <?php else:?>
                              <option value="2" selected="">No [Selected]</option>
                            <?php endif;?>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                            </select>
                            <label for="email">Result Type* </label>
                            <select id="email" class="form-control input-lg" name="result_type">
                              <option value="">Select</option>
                            <?php 
                              if ($general_settings->row()->Result_type==1):?>
                              <option value="1" selected="">Grade Point System [Selected]</option>
                            <?php else:?>
                              <option value="2" selected="">Position System[Selected]</option>
                            <?php endif;?>
                            <option value="1">Grade Point System</option>
                            <option value="2">Position System</option>
                            </select>

                            <label for="email">Check Result Without Logining* <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="This will allow students to check their result without logining into their dashboard"></i></label>
                            <select id="email" class="form-control input-lg" name="check_result">
                              <option value="">Select</option>
                            <?php 
                              if ($general_settings->row()->Check_result_nologin==1):?>
                              <option value="1" selected="">Yes [Selected]</option>
                            <?php else:?>
                              <option value="2" selected="">No[Selected]</option>
                            <?php endif;?>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                            </select>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          <?php echo form_open_multipart('admin/system_settings/logo','class="form-horizontal form-label-left input_mask"');?>
                          <div>
                            <label for="fullname">Current Logo</label>
                            <span id="fullname"><img src="<?php echo base_url();?>assets/dashboard/images/logo/<?php echo htmlentities($general_settings->row()->Site_logo);?>"></span>
                          </div>
                          <div class="clearfix"></div>
                            <label for="fullname">Logo and Favicon* </label>
                            <input type="file" id="fullname" class="form-control input-lg" name="logo"/>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <p><?php echo $general_settings->row()->footer_text;?></p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
      <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
      </ul>
      <div class="clearfix"></div>
      <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/iCheck/icheck.min.js"></script>
    <!-- PNotify -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>assets/dashboard/build/js/custom.min.js"></script>
	
  </body>
</html>