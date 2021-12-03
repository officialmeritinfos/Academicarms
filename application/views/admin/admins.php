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

            <div class="row">
              <!--========================Start of Table====================================-->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $pagename;?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30 text-center text-danger" style="font-size: 16px;" >
                      As a super administrator you can only see other administrators and alter their data but not a super administrator
                    </p>
                    <p class="text-muted font-13 m-b-30">
                     <button class="btn btn-info" data-toggle="modal" data-target="#create_position"><i class="fa fa-key"></i> Add Administrator</button>
                    </p>
                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>                            
                        <?php echo $this->session->flashdata('message'); ?>                                  
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php 
                    if ($admins->num_rows() <1):?>
                            <div class="bs-example" data-example-id="simple-jumbotron">
                              <div class="jumbotron">
                                <h1 class="text-center">NO DATA AVAILBLE</h1>
                                <p class="text-center">Use the Button above to add data to this page</p>
                              </div>
                            </div>
                      <?php else:?>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Admin Level</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                        $cnt=0;
                        foreach ($admins->result() as $admin): 
                          $cnt++; 
                        ?>
                        <tr>
                          <td><?php echo $cnt;?></td>
                          <td><?php echo htmlentities($admin->Name);?></td>
                          <td><?php echo htmlentities($admin->Email);?></td> <td>
                            <?php 
                            if ($admin->Admin_type==1):?>
                              <label class="label label-success">Superadmin</label>
                            <?php else:?>
                              <label class="label label-info">Admin</label>
                            <?php endif;?>
                          </td>
                          <td>
                            <?php 
                            if ($admin->Status==1):?>
                              <label class="label label-success">Active</label>
                            <?php elseif ($admin->Status==3):?>
                              <label class="label label-warning">Banned</label>
                            <?php else:?>
                              <label class="label label-danger">Inactive</label>
                            <?php endif;?>
                          </td>
                          <td>
                            <button class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#delete_classes" data-value="<?php echo htmlentities($admin->admin_id);?>"><i class="fa fa-times-circle"></i></button>
                            <?php 
                            if ($admin->Status==1):?>
                            <button class="btn btn-warning btn-sm" title="Ban" data-toggle="modal" data-target="#ban_classes" data-value="<?php echo htmlentities($admin->admin_id);?>"><i class="fa fa-lock"></i></button>
                            <?php elseif ($admin->Status==3):?>
                            <button class="btn btn-success btn-sm" title="Activate" data-toggle="modal" data-target="#unban_classes" data-value="<?php echo htmlentities($admin->admin_id);?>"><i class="fa fa-unlock"></i></button>
                            <?php endif;?>
                            <button class="btn btn-info btn-sm" title="Edit" data-toggle="modal" data-target="#edit_classes" data-value="<?php echo htmlentities($admin->admin_id);?>"><i class="fa fa-edit"></i></button>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <!--========================================End of Table Row================================-->
              <!--========================================Start of modal for Adding Data==========================-->
                  <div class="modal fade bs-example-modal-lg" id="create_position" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Create</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/admins/create','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="name" type="text" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="email" type="text" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="password" type="password" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Admin Level<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="last-name" name="adminlevel" rows="1" class="form-control col-md-7 col-xs-12">
                                  <option value="">Assign Level</option>
                                  <option value="1">Superadmin</option>
                                  <option value="2" selected="">Admin</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="last-name" name="status" rows="1" class="form-control col-md-7 col-xs-12">
                                  <option value="">Assign Status</option>
                                  <option value="1" selected="">Active</option>
                                  <option value="2">Inactive</option>
                                  <option value="3">Banned</option>
                                </select>
                              </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for Adding data==========================-->
              <!--========================================Start of modal for editind Data==========================-->
                  <div class="modal fade bs-example-modal-lg" id="edit_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Edit</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/admins/edit','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="name" type="text" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Admin Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="id" type="text" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="email" type="text" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last-name" name="password" type="password" rows="1" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Admin Level<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="last-name" name="adminlevel" rows="1" class="form-control col-md-7 col-xs-12">
                                  <option value="">Assign Level</option>
                                  <option value="1">Superadmin</option>
                                  <option value="2" selected="">Admin</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="last-name" name="status" rows="1" class="form-control col-md-7 col-xs-12">
                                  <option value="">Assign Status</option>
                                  <option value="1" selected="">Active</option>
                                  <option value="2">Inactive</option>
                                  <option value="3">Banned</option>
                                </select>
                              </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for editing data==========================-->
              <!--========================================Start of modal for Deleting data==========================-->
                  <div class="modal fade bs-example-modal-lg" id="delete_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Delete</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/admins/delete','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;">Do you really want to delete this Data?</p>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="id" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for Deleting data==========================-->

              <!--========================================Start of modal for Banning data==========================-->
                  <div class="modal fade bs-example-modal-lg" id="ban_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Ban</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/admins/ban','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;">Do you really want to ban this Admin?</p>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="id" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for Ban data==========================-->
               <!--========================================Start of modal for Activate data==========================-->
                  <div class="modal fade bs-example-modal-lg" id="unban_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Activate</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/admins/unban','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;">Do you really want to Activate this Admin?</p>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="id" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for Activating data==========================-->
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

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Datatables -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>assets/dashboard/build/js/custom.min.js"></script>
    <script type="text/javascript">
        $('#edit_classes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            if(recipient) 
            {
                $.ajax(
                {
                    url: '<?php echo base_url();?>admin/admins/get_admin_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            stat=value.Status;
                            $('input[name="name"]').val(value.Name);
                            $('input[name="id"]').val(value.admin_id);
                            $('input[name="email"]').val(value.Email);
                        });
                    }
                });
            }
            else
            {
                $('select[name="id"]').empty();
            }
        })
    </script>
    <script type="text/javascript">
        $('#delete_classes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('input[name="id"]').val(recipient);
        })
    </script>
    <script type="text/javascript">
        $('#ban_classes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('input[name="id"]').val(recipient);
        })
    </script>
    <script type="text/javascript">
        $('#unban_classes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('input[name="id"]').val(recipient);
        })
    </script>
  </body>
</html>