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
                    <p class="text-muted font-13 m-b-30">

                    </p>
                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>                            
                        <?php echo $this->session->flashdata('message'); ?>                                  
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php 
                    if ($positions->num_rows() <1):?>
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
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                        $cnt=0;
                        foreach ($positions->result() as $position): 
                          $typ=$this->db->select('*')->from('Result_type')->where('Type_id',$position->Result_type)->get();
                          $cnt++; 
                        ?>
                        <tr>
                          <td><?php echo $cnt;?></td>
                          <td><?php echo htmlentities($typ->row()->Name);?></td>
                          <td>
                            <a href="<?php echo base_url();?>admin/positions/view_position_type_student/<?php echo htmlentities($position->Session);?>/<?php echo htmlentities($position->Term);?>/<?php echo htmlentities($position->Class);?>/<?php echo htmlentities($position->Student);?>/<?php echo htmlentities($position->Result_type);?>"><button class="btn-primary btn-sm btn" title="Edit"><i class="fa fa-eye"></i></button>
                            
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
                    url: '<?php echo base_url();?>admin/grades/get_grade_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            stat=value.Status;
                            $('input[name="name"]').val(value.Name);
                            $('input[name="minscore"]').val(value.Min_Score);
                            $('input[name="maxscore"]').val(value.Max_Score);
                            $('textarea[name="comment"]').val(value.Comment);
                            $('input[name="gradepoint"]').val(value.Grade_point);
                            $('input[name="id"]').val(value.Grade_id);
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
    $(document).ready(function() {
        $('select[name="class"]').on('change', function() {
            var parentID = $(this).val();
            if(parentID) {
                $.ajax({
                    url: '<?php echo base_url();?>admin/results/get_class_students/'+parentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="student"]').empty();
                        $('select[name="student"]').prepend('<option value=""> Select Students</option>');
                        $.each(data, function(key, value) {
                            $('select[name="student"]').append('<option value="'+ value.Student_id +'">'+ value.Name +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="student"]').empty();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="class"]').on('change', function() {
            var parentID = $(this).val();
            if(parentID) {
                $.ajax({
                    url: '<?php echo base_url();?>admin/results/get_class_subject/'+parentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            var namefield='<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">'+value.Subject_name+'<span class="required" style="color: red;">*</span></label><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" value="'+value.Subject_id+'" id="first-name" name="name[]" class="form-control col-md-7 col-xs-12" style="display:none;"></div></div>';
                            var examfield='<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Exam Score<span class="required" style="color: red;">*</span></label><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" id="first-name" name="examscore[]" class="form-control col-md-7 col-xs-12"></div></div>';
                            var testfield='<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Test Score<span class="required" style="color: red;">*</span></label><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" id="first-name" name="testscore[]" class="form-control col-md-7 col-xs-12"></div></div>';
                            $('.form').append(namefield);
                            $('.form').append(examfield);
                            $('.form').append(testfield);
                        });
                    }
                });
            }else{
                $('select[name="student"]').empty();
            }
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