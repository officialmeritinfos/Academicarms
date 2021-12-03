              <!--========================================Start of modal for Adding Teacher==========================-->
                   <div class="modal fade bs-example-modal-lg" id="create" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Create Teacher</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/teachers/create_teacher','class="form-horizontal form-label-left input_mask"');?>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Name" name="name">
                              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control" id="inputSuccess3" placeholder="Email" name="email">
                              <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                              <select class="form-control has-feedback-left" id="inputSuccess4" name="class">
                                <option value="">Assign a class</option>
                                <?php 
                                foreach ($classes->result() as $class):?>
                                  <option value="<?php echo htmlentities($class->Class_id);?>"><?php echo htmlentities($class->Name);?></option>
                                <?php endforeach?>
                              </select>
                              <span class="fa fa-university form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                              <select class="form-control has-feedback-left" id="inputSuccess4" name="status">
                                <option value="">Select Option</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                              </select>
                              <span class="fa fa-check form-control-feedback left" aria-hidden="true"></span>
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
              <!--========================================End of modal for Adding Teacher==========================-->
              <!--========================================Start of modal for Adding Teacher(Batch)==========================-->
                  <div class="modal fade bs-example-modal-lg" id="create_batch" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Create Teacher</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/teachers/create_teacher_batch','class="form-horizontal form-label-left input_mask"');?>
                          <div class="form">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control" id="inputSuccess3" placeholder="Email" name="email[]">
                              <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                            </div>
                          </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-warning" type="reset">Reset</button>
                                <button class="btn btn-info" type="button" id="add_column"><i class="fa fa-plus"></i> Add Column</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for Adding Teacher(Batch)==========================-->

              <!--========================================Start of modal for Editing Teacher==========================-->
                  <div class="modal fade bs-example-modal-lg" id="edit_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Edit Teacher</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/teachers/edit_teacher','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="name" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="email" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Class<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="first-name" name="class" class="form-control col-md-7 col-xs-12">
                                  <option value="">Assign a class</option>
                                  <?php 
                                  foreach ($classes->result() as $class):?>
                                    <option value="<?php echo htmlentities($class->Class_id);?>"><?php echo htmlentities($class->Name);?></option>
                                  <?php endforeach?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="teacher_id" class="form-control col-md-7 col-xs-12">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="last-name" name="status" class="form-control col-md-7 col-xs-12">
                                  <option value="">Select Option</option>
                                  <option value="1">Active</option>
                                  <option value="2">Inactive</option>
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
              <!--========================================End of modal for Editing Teacher==========================-->
              <!--========================================Start of modal for Deleting Teacher==========================-->
                  <div class="modal fade bs-example-modal-lg" id="delete_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Delete Teacher</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/teachers/delete','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;">Do you really want to delete this teacher?</p>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="teacher_id" class="form-control col-md-7 col-xs-12">
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
              <!--========================================End of modal for Deleting Teacher==========================-->
              <!--========================================Start of modal for Removing Teache From Classr==========================-->
                  <div class="modal fade bs-example-modal-lg" id="remove_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Remove Teacher From Class</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/teachers/remove_class','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;">Do you really want to remove this teacher from the class?</p>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="teacher_id" class="form-control col-md-7 col-xs-12">
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
              <!--========================================End of modal for Removing Teacher From Class==========================-->

              <!--========================================Start of modal for Truncating Data==========================-->
                  <div class="modal fade bs-example-modal-lg" id="truncate" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Empty Database Table</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/teachers/truncate','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;"><i class="fa fa-warning"></i> Do you really want to Truncate all the data?</p><p class="text-center"> This cannot be undone once initiated.</p>
                            <div class="form-group" style="display: none;">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Id<span class="required" style="color: red;">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" name="id" value="1" class="form-control col-md-7 col-xs-12">
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
              <!--========================================End of modal for Truncating data==========================-->
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
                    url: '<?php echo base_url();?>admin/teachers/get_teacher_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            stat=value.Status;
                            $('input[name="name"]').val(value.Name);
                            $('input[name="teacher_id"]').val(value.Teacher_id);
                            $('input[name="email"]').val(value.Email);
                        });
                    }
                });
            }
            else
            {
                $('select[name="teacher_id"]').empty();
            }
        })
    </script>
    <script type="text/javascript">
        $('#delete_classes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('input[name="teacher_id"]').val(recipient);
        })
    </script>
    <script type="text/javascript">
        $('#remove_classes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('input[name="teacher_id"]').val(recipient);
        })
    </script>
<script type="text/javascript">
  $(document).ready(function() {
    var namfield='<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"><input type="text" class="form-control" id="inputSuccess3" placeholder="Name" name="name[]"><span class="fa fa-user form-control-feedback right" aria-hidden="true"></span></div>';
    var emailfield='<div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback"><input type="text" class="form-control" id="inputSuccess3" placeholder="Email" name="email[]"><span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span></div>';
    $('#add_column').on('click', function() {
      //$('select[name="products"]').append('<option value=" ">Select Product</option>');
      $('.form').append(emailfield);
    });
  });
</script>
  </body>
</html>