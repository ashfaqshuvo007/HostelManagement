<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>

<?php

//Counting num of rooms
$r_qry = $connection->prepare("SELECT COUNT(*)FROM `rooms`");
$r_qry->execute();
$r_num = $r_qry->fetchColumn();

//Counting num of borders
$r_qry = $connection->prepare("SELECT COUNT(*)FROM `borders`");
$r_qry->execute();
$b_num = $r_qry->fetchColumn();

//Counting num of borders
$doc = $connection->prepare("SELECT COUNT(*)FROM `documents`");
$doc->execute();
$doc = $doc->fetchColumn();

?>


    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-bed fa-3x"></i>
                <div class="info">
                    <h4>Rooms</h4>
                    <p><b><?php echo $r_num ;?></b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Borders</h4>
                    <p><b><?php echo $b_num ;?></b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Border Documents</h4>
                    <p><b><?php echo $doc ;?></b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                <div class="info">
                    <h4>Stars</h4>
                    <p><b>500</b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile row">
            <div class="col-md-3">
              <div id="external-events">
                <h4 class="mb-4">Draggable Events</h4>
                <div class="fc-event">My Event 1</div>
                <div class="fc-event">My Event 2</div>
                <div class="fc-event">My Event 3</div>
                <div class="fc-event">My Event 4</div>
                <div class="fc-event">My Event 5</div>
                <p class="animated-checkbox mt-20">
                  <label>
                    <input id="drop-remove" type="checkbox"><span class="label-text">Remove after drop</span>
                  </label>
                </p>
              </div>
            </div>
            <div class="col-md-9">
              <div id="calendar"></div>
            </div>
          </div>
        </div>
      </div>
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Monthly Sales</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Support Requests</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'inc/footer.php'; ?>