        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-4 col-sm-6 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Students</span>
              <div class="count"><?php echo htmlentities($Students->num_rows());?></div>
              <span class="count_bottom"><i class="green"></i> </span>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Results In Class</span>
              <div class="count"><?php echo htmlentities($Results->num_rows());?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i>Grouped according Students</span>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Subjects In Class</span>
              <div class="count"><?php echo htmlentities($Subjects->num_rows());?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i></span>
            </div>
          </div>
          <!-- /top tiles -->

          
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->