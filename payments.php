<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Payments</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Payments</a></li>
        </ul>
    </div>

    <?php 
    $border = $connection->prepare("SELECT `border_id`, `name` FROM `borders`");
    $border->execute();
    $border = $border->fetchAll();

    $room = $connection->prepare("SELECT `room_id` FROM `rooms`");
    $room->execute();
    $room = $room->fetchAll();



    if (isset($_POST['pay_btn'])) {
       $border = $_POST['border_id'];
       $room = $_POST['room_id'];
       $month = $_POST['month'];
       $paid_amount = $_POST['paid_amount'];
       $errors = [];
       $msgs = [];

       //check validation
       //
       //if no errors
       if (empty($errors)) {
           $query = $connection->prepare("INSERT INTO `payment`(`border_id`,`room_id`,`month`,`paid_amount`) VALUES(:border_id,:room_id,:month,:paid_amount)");
           $query->bindValue(':border_id',$border);
           $query->bindValue(':room_id',$room);
           $query->bindValue(':month',$month);
           $query->bindValue(':paid_amount',$paid_amount);
           $query->execute();

           $msgs[] = "Payment Added Successfully !";
       }else {
           $errors[] = "Payment Not Added Successfully !";
       }

    }

    ?>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($msgs)) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php foreach ($msgs as $msg): ?>
                        <strong><?php echo $msg; ?></strong>
                    <?php endforeach; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            <?php if (!empty($errors)){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <strong><?php echo $error; ?></strong>
                    <?php endforeach; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            <div class="tile">
                <!-- <h3 class="tile-title">Subscribe</h3> -->

                <div class="tile-body">
                    <form class="row" action="payments.php" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Border</label>
                                <select name="border_id" class="form-control">
                                    <option>Select Border</option>
                                    <?php foreach ($border as $value): ?>
                                        <option value="<?php echo $value['border_id']; ?>"><?php echo $value['name']; ?></option>
                                    <?php endforeach ?>
            	                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Room</label>
                                <select name="room_id" class="form-control">
                                    <option>Select Room</option>
                                    <?php foreach ($room as $value): ?>
                                        <option value="<?php echo $value['room_id']; ?>">Room <?php echo $value['room_id']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Month Of</label>
                                <select name="month" class="form-control">
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Paid Amount</label>
                                <input type="text" name="paid_amount" class="form-control col-md-10" placeholder="">
                            </div>
                        </div>
                        <div class="form-group col-md-2 align-self-end">
                            <button class="btn btn-primary" name="pay_btn" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php 
            $stmt = $connection->prepare("SELECT * FROM `payment`");
            $stmt->execute();
            $payment = $stmt->fetchAll();
        ?>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Payment Details</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Border Name</th>
                                <th>Room No.</th>
                                <th>Month</th>
                                <th>Payable Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i=1; foreach ($payment as $value): ?>
                            <?php 
                                $name = $connection->prepare("SELECT `name` FROM `borders` WHERE `border_id` = :border_id");
                                $name->bindValue(':border_id', $value['border_id']);
                                $name->execute();
                                $name = $name->fetch();

                                $bill = $connection->prepare("SELECT `total_payable` FROM `bills` WHERE `border_id` = :border_id");
                                $bill->bindValue(':border_id', $value['border_id']);
                                $bill->execute();
                                $bill = $bill->fetch();

                                $total = $bill['total_payable'];
                                

                            ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $name['name']; ?></td>
                                <td>Room <?php echo $value['room_id']; ?></td>
                                <td><?php echo $value['month']; ?></td>
                                <td><?php echo $total ?></td>
                                <td><?php echo $value['paid_amount']; ?></td>
                                <td><?php

                                 $paid = $value['paid_amount']; 

                                 $due = $total-$paid;
                                 
                                 if ($paid < $total) {
                                     echo "<p class='badge badge-danger'> $due</p>";
                                 }
                                 
                                 ?></td>
                                <td>
                                    <a href="paidBills.php?pid=<?php echo $value['payment_id'];?>" class="btn btn-primary btn-sm text-white" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Paid</a>
                                </td> 
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'inc/footer.php'; ?>