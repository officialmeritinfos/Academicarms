
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $pagename;?> || <?php echo $Site_name;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/dashboard/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/dashboard/build/css/custom.min.css" rel="stylesheet">


  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $pagename;?></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $pagename;?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>-->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content table-responsive"><br>
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-12 invoice-header">
                          <h1>
                            <img src="<?php echo base_url();?>assets/dashboard/images/logo/<?php echo htmlentities($general_settings->row()->Site_logo);?>"><br>
                          </h1>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                          From
                          <address>
                                          <strong><?php echo htmlentities($general_settings->row()->Site_name);?> .</strong>
                                          <br>Teacher: <b><?php echo htmlentities($teacher->row()->Name);?></b>
                                          <br>Teacher Email: <b><?php echo htmlentities($teacher->row()->Email);?></b>
                                      </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          To
                          <address>
                                          Name: <strong><?php echo htmlentities($student->row()->Name);?></strong>
                                          <br>Username: <strong><?php echo htmlentities($student->row()->Reg_no);?></strong>
                                          <br>Email: <strong><?php echo htmlentities($student->row()->Email);?></strong>
                                      </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <b>Academic Session:</b><?php echo htmlentities($session->row()->Name);?>
                          <br>
                          <b>Semester/Term:</b> <?php echo htmlentities($semester->row()->Name);?>
                          <br>
                          <b>Date Printed:</b>  <?php echo date('d/m/Y H:i:s a',time());?>
                          <br>
                          <b>Class Reference:</b> <?php echo htmlentities($class->row()->ClassRef);?>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    <table id="table-responsive" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Subject</th>
                          <th>Subject Code</th>
                          <th>Test Score</th>
                          <th>Exam Score</th>
                          <th>Total Score</th>
                          <th>Grade</th>
                          <?php 
                          if ($general_settings->row()->Result_type==1):?>
                          <th>Unit Load</th>
                          <th>Grade Point</th>
                          <th>Unit Point</th>
                          <?php endif;?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php 
                        $unitload=0;
                        $unitpoint=0;
                        $scores=0;
                        $cnt=0;
                        foreach ($sresults->result() as $sresult):
                          $cnt++;
                          $unitload+=$sresult->Unit_load;
                          $unitpoint+=$sresult->Unit_point;
                          $scores+=$sresult->Total_score;
                        ?>
                        <tr>
                          <td><?php echo htmlentities($cnt);?></td>
                          <td><?php echo htmlentities($sresult->Subject_name);?></td>
                          <td><?php echo htmlentities($sresult->Subject_code);?></td>
                          <td><?php echo htmlentities($sresult->Test_score);?></td>
                          <td><?php echo htmlentities($sresult->Exam_score);?></td>
                          <td><?php echo htmlentities($sresult->Total_score);?></td>
                          <td><?php echo htmlentities($sresult->Grade);?></td>
                          <?php 
                          if ($general_settings->row()->Result_type==1):?>
                          <td><?php echo htmlentities($sresult->Unit_load);?></td>
                          <td><?php echo htmlentities($sresult->Gradepoint);?></td>
                          <td><?php echo htmlentities($sresult->Unit_point);?></td>
                          <?php endif;?>
                        </tr>
                      <?php endforeach;?>
                       <?php 
                          if ($general_settings->row()->Result_type==1):?>
                        <tr>
                          <td colspan="7" class="text-right">Total Unit Load</td>
                          <td><?php echo htmlentities($unitload);?></td>
                        </tr>
                        <tr>
                          <td colspan="9" class="text-right">Total Unit Point</td>
                          <td><?php echo htmlentities($unitpoint);?></td>
                        </tr>
                        <tr>
                          <td colspan="9" >CGPA</td>
                          <td><?php echo htmlentities($unitpoint/$unitload);?></td>
                        </tr>
                        <tr>
                          <td colspan="10">
                            <button class="pull-right btn btn-primary"onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                          </td>
                        </tr>
                        <?php endif;?>

                        <?php 
                          if ($general_settings->row()->Result_type==2):?>
                        <tr>
                          <td colspan="5" class="text-right">Aggregate Score</td>
                          <td><?php echo htmlentities($scores);?></td>
                        </tr>
                        <tr>
                          <td colspan="6" class="text-right">Average</td>
                          <td><?php echo htmlentities($scores/$cnt);?></td>
                        </tr>
                        <tr>
                          <td colspan="6" >Position</td>
                          <td><span style="font-size: 20px;"> <?php echo htmlentities($position->row()->Position);?></span> Out Of <strong style="font-size: 20px;"><?php echo htmlentities($class->num_rows());?></strong></td>
                        </tr>
                        <?php if ($position->row()->Headteacher_comment !='') {?>
                        <tr>
                          <td colspan="3" >HeadTeacher's Comment</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><span style="font-size: 20px;"> <?php echo htmlentities($position->row()->Headteacher_comment);?></span></td>
                        </tr>
                      <?php }?>
                      <?php if ($position->row()->Teacher_comment !='') {?>
                        <tr>
                          <td colspan="4" >Teacher's Comment</td>
                          <td></td>
                          <td></td>
                          <td><span style="font-size: 20px;"> <?php echo htmlentities($position->row()->Teacher_comment);?></span></td>
                        </tr>
                      <?php }?>
                      <?php if ($position->row()->Principal_comment !='') {?>
                        <tr>
                          <td colspan="5" >Principal's Comment</td>
                          <td></td>
                          <td><span style="font-size: 20px;"> <?php echo htmlentities($position->row()->Principal_comment);?></span> </td>
                        </tr>
                      <?php }?>

                        <?php
                        $result_type=$this->db->select('*')->from('Result_type')->where('Type_id',$position->row()->Result_type)->get();
                        ?>
                        <tr>
                          <td colspan="6" class="text-right">Result Type</td>
                          <td><?php echo htmlentities($result_type->row()->Name);?></td>
                        </tr>
                        <tr>
                          <td colspan="7">
                            <button class="pull-right btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                          </td>
                        </tr>
                        <?php endif;?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

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
    <!-- iCheck -->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/iCheck/icheck.min.js"></script>
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

  </body>
</html>