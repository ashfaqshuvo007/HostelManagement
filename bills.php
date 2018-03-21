<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Bills</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Bills</a></li>
        </ul>
    </div>

<?php 
$border = $connection->prepare("SELECT `border_id`, `name` FROM `borders`");
$border->execute();
$border = $border->fetchAll();

$room = $connection->prepare("SELECT `room_id` FROM `rooms`");
$room->execute();
$room = $room->fetchAll();


if (isset($_POST['add_bills'])) {
    $border_id = trim($_POST['border_id']);
    $room_id = trim($_POST['room_id']);
    $room_rent = trim($_POST['room_rent']);
    $gas_bill = trim($_POST['gas_bill']);
    $ellectricity_bill = trim($_POST['ellectricity_bill']);
    $month = trim($_POST['month']);
    $errors = [];
    $msgs = [];

    // Validation Check
    // 
    //if no errors
    if (empty($errors)) {
        $query = $connection->prepare("INSERT INTO `bills`(`border_id`,`room_id`,`room_rent`,`gas_bill`,`ellectricity_bill`,`month`) VALUES(:border_id,:room_id,:room_rent,:gas_bill,:ellectricity_bill,:month)");
        $query->bindValue(':border_id',$border_id);
        $query->bindValue(':room_id',$room_id);
        $query->bindValue(':room_rent',$room_rent);
        $query->bindValue(':gas_bill',$gas_bill);
        $query->bindValue(':ellectricity_bill',$ellectricity_bill);
        $query->bindValue(':month',$month);
        $query->execute();
        $bid = $connection->lastInsertId();

        $msgs[] = "Bills Added Successfully !";
    }else{
        $errors[] = "Bills Not Added Successfully !";
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
                    <form class="row" action="bills.php" method="post">
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
                                <label class="control-label">Room Rent</label>
                                <input class="form-control" name="room_rent" type="text" placeholder="Ex. 12,000">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Gas Bill</label>
                                <input class="form-control" name="gas_bill" type="text" placeholder="Ex. 12,000">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Ellectricity Bill</label>
                                <input class="form-control" name="ellectricity_bill" type="text" placeholder="Ex. 12,000">
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
                        <div class="form-group col-md-2 align-self-end">
                            <button class="btn btn-primary" name="add_bills" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Bills</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php 

        $stmt = $connection->prepare("SELECT * FROM `bills`");
        $stmt->execute();
        $bill = $stmt->fetchAll();

        ?>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Bill Details</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Border Name</th>
                                <th>Room No.</th>
                                <th>Room Rent</th>
                                <th>Gas Bill</th>
                                <th>Ellectricity Bill</th>
                                <th>Month of</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i =1; foreach ($bill as $value): ?>

                            <?php 
                                $name = $connection->prepare("SELECT `name` FROM `borders` WHERE `border_id` = :border_id");
                                $name->bindValue(':border_id', $value['border_id']);
                                $name->execute();
                                $name = $name->fetch();
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $name['name']; ?></td>
                                <td>Room <?php echo $value['room_id']; ?></td>
                                <td><?php echo $value['room_rent']; ?></td>
                                <td><?php echo $value['gas_bill']; ?></td>
                                <td><?php echo $value['ellectricity_bill']; ?></td>
                                <td><?php echo $value['month']; ?></td>
                                <td>
                                    <?php 

                                    $room_rent = $value['room_rent'];
                                    $gas_bill = $value['gas_bill'];
                                    $ellectricity = $value['ellectricity_bill'];

                                    $total = $room_rent+$gas_bill+$ellectricity;
                                    echo  $total;

                                    $query = $connection->prepare("UPDATE `bills` SET `total_payable` = :total_payable WHERE `bill_id` = :bill_id");
                                    $query->bindValue(':bill_id', $value['bill_id']);
                                    $query->bindValue(':total_payable', $total);
                                    $query->execute();

                                    ?>
                                        
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="reset"><i class="fa fa-fw fa-lg fa-times-circle"></i>Delete</button>
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