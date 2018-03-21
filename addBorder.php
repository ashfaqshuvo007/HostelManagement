<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add Border</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>

<?php
    
    $stmt = $connection->prepare("SELECT * FROM `rooms`");
    $stmt->execute();
    $rooms = $stmt->fetchAll();

    if(isset($_POST['add_border'])){
        $name = $_POST['name'];
        $room_id = $_POST['room_id'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $pre_address = $_POST['pre_address'];
        $perma_address = $_POST['perma_address'];
        $nid = $_POST['nid'];

        $photo = $_FILES['photo']['name'];
        $proof_photo = $_FILES['proof_photo']['name'];

        $photo_tmp = $_FILES['photo']['tmp_name'];
        $proof_photo_tmp = $_FILES['proof_photo']['tmp_name'];

        move_uploaded_file($photo_tmp,"img/borders/$photo");
        move_uploaded_file($proof_photo_tmp,"img/Documents/$proof_photo");

        $f_name = $_POST['f_name'];
        $m_name = $_POST['m_name'];
        $emr_contact = $_POST['emr_contact'];
        $errors = [];
        $msgs = [];

        //Validation Check 
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $errors[] = "Invalid Email Format";
        }

            if (empty($errors)) {
                $query = $connection->prepare("INSERT INTO `borders`(`name`,`room_id`,`email`,`contact`,`pre_address`,`perma_address`,`nid`,`f_name`,`m_name`,`photo`,`emr_contact`) VALUES(:name,:room_id,:email,:contact,:pre_address,:perma_address,:nid,:f_name,:m_name,:photo,:emr_contact)");
                $query->bindValue(':name',$name);
                $query->bindValue(':room_id', $room_id);
                $query->bindValue(':email', $email);
                $query->bindValue(':contact', $contact);
                $query->bindValue(':pre_address', $pre_address);
                $query->bindValue(':perma_address', $perma_address);
                $query->bindValue(':nid', $nid);
                $query->bindValue(':f_name', $f_name);
                $query->bindValue(':m_name', $m_name);
                $query->bindValue(':photo', $photo);
                $query->bindValue(':emr_contact', $emr_contact);
                $query->execute();
                $border_id = $connection->lastInsertId();

                if($query->rowCount() === 1){
                    //Documents insert
                    $msgs[] = "Border Added Successfully !";
                    $stmt = $connection->prepare("INSERT INTO `documents`(`border_id`,`nid`,`proof_photo`,`photo`) VALUES(:border_id,:nid,:proof_photo,:photo)");
                    $stmt->bindValue(':border_id', $border_id);
                    $stmt->bindValue(':nid', $nid);
                    $stmt->bindValue(':proof_photo', $proof_photo);
                    $stmt->bindValue(':photo', $photo);
                    $stmt->execute();

                    //Rooms update
                    $r_qry = $connection->prepare("SELECT * FROM `rooms` WHERE `room_id` = :rid ");
                    $r_qry->bindValue(':rid',$room_id);
                    $r_qry->execute();
                    $room = $r_qry->fetch();

                    if($room['existing_border'] == 0){
                            //no of border update
                        $b_qry = $connection->prepare("UPDATE `rooms` SET `existing_border` = 1 WHERE `room_id` = :rid ");
                        $b_qry->bindValue(':rid',$room_id);
                        $b_qry->execute();
                    
                    }else if($room['existing_border'] > 0){
                             //no of border update
                           $room['existing_border']++;  
                        $b_qry = $connection->prepare("UPDATE `rooms` SET `existing_border` = :existing_border WHERE `room_id` = :rid ");
                        $b_qry->bindValue(':existing_border',$room['existing_border']);
                        $b_qry->bindValue(':rid',$room_id);
                        $b_qry->execute();
                    }

                }else{
                $errors[] = "Border Not Added Successfully!";
            }
        }
    }
    
?>

    <div class="row">
        <div class="col-md-7">
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
                <!-- <h3 class="tile-title">Register</h3> -->
                <form class="form-horizontal" action="addBorder.php" method="post" enctype="multipart/form-data">
                    <div class="tile-body">
                        <div class="form-group row">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-8">
                                <input class="form-control" name="name" type="text" placeholder="Enter full name" required="required">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Room</label>
                            <div class="col-md-8">
                                <select name="room_id" class="form-control" required="required">
                                    <option">Select Room</option>
                                    <?php foreach ($rooms as $value): ?>
                                        <?php if($value['existing_border'] < $value['max_border']  ){?>
                                        <option value="<?php echo $value['room_id']; ?>"> Room <?php echo $value['room_id']; ?></option>
                                        <?php } ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-8">
                                <input class="form-control" name="email" type="email" placeholder="Enter email address" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Contact No.</label>
                            <div class="col-md-8">
                                <input class="form-control" name="contact" type="number" placeholder="+8801010101010" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Present Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="pre_address" rows="3" placeholder="Enter your present address" required="required"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Parmanent Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="perma_address" rows="3" placeholder="Enter your permanent address" required="required"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">NID No.</label>
                            <div class="col-md-8">
                                <input class="form-control" name="nid" type="number" placeholder="Enter NID Number" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Father's Name</label>
                            <div class="col-md-8">
                                <input class="form-control" name="f_name" type="text" placeholder="Enter Father name" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Mother's Name</label>
                            <div class="col-md-8">
                                <input class="form-control" name="m_name" type="text" placeholder="Enter Mother name" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Emergency Contact</label>
                            <div class="col-md-8">
                                <input class="form-control" name="emr_contact" type="number" placeholder="Emergency contact" required="required">
                            </div>
                        </div>
                       <!-- <div class="form-group row">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender">Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender">Female
                                    </label>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Border Photo</label>
                            <div class="col-md-8">
                                <input class="form-control" name="photo" type="file" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Picture Id </label>
                            <div class="col-md-8">
                                <input class="form-control" name="proof_photo" type="file" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox">I accept the terms and conditions
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                                <button class="btn btn-primary" name="add_border" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-secondary" type="reset"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include 'inc/footer.php'; ?>