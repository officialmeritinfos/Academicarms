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
                     <button class="btn btn-primary" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Add Teacher</button><button class="btn btn-primary" data-toggle="modal" data-target="#create_batch"><i class="fa fa-plus"></i> Add Teacher(Batch)</button><button class="btn btn-danger" data-toggle="modal" data-target="#truncate"><i class="fa fa-ban"></i> Delete Every Data</button>
                    </p>
                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>                            
                        <?php echo $this->session->flashdata('message'); ?>                                  
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php 
                    if ($teachers->num_rows() <1):?>
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
                          <th>Class</th>
                          <th>Date Added</th>
                          <th>Last Udated</th>
                          <th>Action</th>
                          <th>Status</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                        $cnt=0;
                        foreach ($teachers->result() as $teacher): 
                        $cnt++; 
                        $class=$this->db->select('*')->from('Classes')->where('Class_id',$teacher->Class)->get();
                        ?>
                        <tr>
                          <td><?php echo $cnt;?></td>
                          <td><?php echo htmlentities($teacher->Name);?></td>
                          <td><?php echo htmlentities($teacher->Email);?></td>
                          <td><?php echo htmlentities($class->row()->Name);?></td>
                          <td><?php echo htmlentities($teacher->RegDate);?></td>
                          <td><?php echo htmlentities($teacher->DateUpdated);?></td>
                          <td>
                            <button class="btn-primary btn-sm btn" title="Edit Teacher" data-toggle="modal" data-target="#edit_classes" data-value="<?php echo htmlentities($teacher->Teacher_id);?>"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" title="Delete Teacher" data-toggle="modal" data-target="#delete_classes" data-value="<?php echo htmlentities($teacher->Teacher_id);?>"><i class="fa fa-times-circle"></i></button>
                            <button class="btn btn-warning btn-sm" title="Remove Teacher From Class" data-toggle="modal" data-target="#remove_classes" data-value="<?php echo htmlentities($teacher->Teacher_id);?>"><i class="fa fa-times-circle"></i></button>
                          </td>
                          <td>
                            <?php if ($teacher->Status==1):?>
                            <label class="label label-success">Active</label>
                            <?php else:?>
                              <label class="label label-info">Inactive</label>
                            <?php endif?>
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