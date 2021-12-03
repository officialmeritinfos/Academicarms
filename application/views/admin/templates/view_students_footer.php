<!--========================================Start of modal for Adding==========================-->
                  <div class="modal fade bs-example-modal-lg" id="promote_demote" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Promote & Demote</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/students/promote_demote','class="form-horizontal form-label-left input_mask"');?>
                          <div class="form"><br>
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                              <select class="form-control input-lg" id="inputSuccess3" name="class">
                                <option value="">Select Class</option>
                                <?php foreach ($classes->result() as $class):?>
                                  <option value="<?php echo htmlentities($class->Class_id);?>"><?php echo htmlentities($class->Name);?></option>
                                <?php endforeach;?>
                              </select>
                              <span class="fa fa-book form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                              <select class="form-control input-lg" id="inputSuccess3" name="name[]" multiple="">
                                <option value="">Select Student</option>
                                <?php foreach ($students->result() as $stud):?>
                                  <option value="<?php echo htmlentities($stud->Student_id);?>"><?php echo htmlentities($stud->Name);?></option>
                                <?php endforeach;?>
                              </select>
                              <span class="fa fa-book form-control-feedback right" aria-hidden="true"></span>
                            </div>
                          </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                                
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          <?php echo form_close();?>
                        </div>
                      </div>
                    </div>
                  </div>
              <!--========================================End of modal for Promoting and Demoting==========================-->
              <!--========================================Start of modal for Deleting==========================-->
                  <div class="modal fade bs-example-modal-lg" id="delete_classes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Delete</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open('admin/students/delete','id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                           <p class="text-center" style="color: red;font-weight: bold;font-size: 20px;">Do you really want to delete this data?</p>
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
              <!--========================================End of modal for Deleting==========================-->
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
                    url: '<?php echo base_url();?>admin/subjects/get_subject_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            stat=value.Status;
                            $('input[name="name"]').val(value.Subject_name);
                            $('input[name="id"]').val(value.Subject_id);
                            $('input[name="subcode"]').val(value.Subject_code);
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
            $('input[name="id"]').val(recipient);
        })
    </script>
<script type="text/javascript">
  $(document).ready(function() {
    $('input[name="subject[]"]').on('keyup', function() {
      var typing= $(this).val();
      $('input[name="check"]').val(typing);
      if(typing) 
            {
                $.ajax(
                {
                    url: '<?php echo base_url();?>admin/subjects_combination/get_subject_id/'+typing,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            $('input[name="check"]').val(value.Subject_name);
                        });
                    }
                });
            }
            else
            {
                $('select[name="teacher_id"]').empty();
            }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var namefield='<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"><input type="text" class="form-control input-lg" placeholder="Name" id="inputSuccess3" name="name[]"><span class="fa fa-user form-control-feedback right" aria-hidden="true"></span></div>';
    var emailfield='<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"><input type="text" class="form-control input-lg" name="email[]" placeholder="Email" id="inputSuccess3"><span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span></div>';
    var userfield='<div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback"><input type="text" class="form-control input-lg" id="inputSuccess3" name="username[]" placeholder="Reg No/Username"><span class="fa fa-user form-control-feedback right" aria-hidden="true"></span></div>';
    $('#add_column').on('click', function() {
      //$('select[name="products"]').append('<option value=" ">Select Product</option>');
      $('.form').append(namefield);
      $('.form').append(emailfield);
      $('.form').append(userfield);
    });
  });
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
  </body>
</html>