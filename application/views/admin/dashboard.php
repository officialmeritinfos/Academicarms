        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Students</span>
              <div class="count"><?php echo htmlentities($Students->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Class</span>
              <div class="count"><?php echo htmlentities($Classes->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Teachers</span>
              <div class="count green"><?php echo htmlentities($Teachers->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-file-pdf-o"></i> Total Results Published</span>
              <div class="count"><?php echo htmlentities($Results_published->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-file-o"></i> Total Unpublished Results</span>
              <div class="count"><?php echo htmlentities($Results_unpublished->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-ticket"></i> Total Unused Result Pins</span>
              <div class="count"><?php echo htmlentities($Result_pin_unused->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-ticket"></i> Total Result Pins Used</span>
              <div class="count"><?php echo htmlentities($Result_pin_used->num_rows());?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-th"></i> Total Subjects</span>
              <div class="count"><?php echo htmlentities($Subjects->num_rows());?></div>
            </div>
          </div>
          <!-- /top tiles -->

          
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->