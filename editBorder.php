<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Edit Border</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Edit Border</a></li>
        </ul>
    </div>

<?php
    if (isset($_GET['border_id'])) {
        $query = $connection->prepare("SELECT * FROM `borders` WHERE `border_id` = :border_id");
        $query->bindValue(':border_id', $_GET['border_id'], PDO::PARAM_INT);
        $query->execute();
        $border = $query->fetch();
    }

    $stmt = $connection->prepare("SELECT * FROM `rooms`");
    $stmt->execute();
    $rooms = $stmt->fetchAll();

    if(isset($_POST['update_border'])){
        $name = $_POST['name'];
        $room_id = $_POST['room_id'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $pre_address = $_POST['pre_address'];
        $perma_address = $_POST['perma_address'];
        $nid = $_POST['nid'];
        
        if (!empty(($_FILES['photo']['tmp_name']) && ($_FILES['proof_photo']['tmp_name']))) {
            
        $photo = $_FILES['photo']['name'];
        $proof_photo = $_FILES['proof_photo']['name'];

        $photo_tmp = $_FILES['photo']['tmp_name'];
        $proof_photo_tmp = $_FILES['proof_photo']['tmp_name'];

        move_uploaded_file($photo_tmp,"img/borders/$photo");
        move_uploaded_file($proof_photo_tmp,"img/Documents/$proof_photo");
        }
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
            $query = $connection->prepare("UPDATE `borders` SET `name` = :name,`room_id` = :room_id,`email = :email`,`contact` = :contact,`pre_address` = :pre_address,`perma_address` = :perma_address,`nid` = :nid,`f_name` = :f_name,`m_name` = :m_name,`photo` = :photo,`emr_contact` = :emr_contact WHERE `border_id` = :border_id");
            $query->bindValue(':border_id',$_GET['border_id'], PDO::PARAM_INT);
            $query->bindValue(':name',$name);
            $query->bindValue('room_id', $room_id);
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
                $msgs[] = "Border Updated Successfully !";
                $stmt = $connection->prepare("UPDATE `documents` SET `border_id` = :border_id,`nid` = :nid,`proof_photo` = :proof_photo,`photo` = :photo WHERE `border_id` = :b_id");
                $stmt->bindValue(':b_id', $_GET['border_id'], PDO::PARAM_INT);
                $stmt->bindValue(':border_id', $border_id);
                $stmt->bindValue(':nid', $nid);
                $stmt->bindValue(':proof_photo', $proof_photo);
                $stmt->bindValue(':photo', $photo);
                $stmt->execute();

            }else{
            $errors[] = "Border Not Updated Successfully!";
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
                <form class="form-horizontal" action="borders.php" method="post" enctype="multipart/form-data">
                    <div class="tile-body">
                        <div class="form-group row">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-8">
                                <input class="form-control" name="name" type="text" value="<?php echo $border['name']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Room</label>
                            <div class="col-md-8">
                                <select name="room_id" class="form-control">
                                    <option">Select Room</option>
                                    <?php foreach ($rooms as $value): ?>
                                        <option value="<?php echo $value['room_id']; ?>"> Room <?php echo $value['room_id']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-8">
                                <input class="form-control" name="email" type="email" value="<?php echo $border['email']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Contact No.</label>
                            <div class="col-md-8">
                                <input class="form-control" name="contact" type="number" value="<?php echo $border['contact']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Present Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="pre_address" rows="3"><?php echo $border['pre_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Parmanent Address</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="perma_address" rows="3"><?php echo $border['perma_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">NID No.</label>
                            <div class="col-md-8">
                                <input class="form-control" name="nid" type="number" value="<?php echo $border['nid']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Father Name</label>
                            <div class="col-md-8">
                                <input class="form-control" name="f_name" type="text" value="<?php echo $border['f_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Mother Name</label>
                            <div class="col-md-8">
                                <input class="form-control" name="m_name" type="text" value="<?php echo $border['m_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Emergency Contact</label>
                            <div class="col-md-8">
                                <input class="form-control" name="emr_contact" type="number" value="<?php echo $border['emr_contact']; ?>">
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
                            <img width="100" class="img-fluid" src="img/borders/<?php echo $border['photo']; ?>" alt="Border Image">
                                <input class="form-control" name="photo" type="file">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Picture Id </label>
                            <div class="col-md-8">
                            <img width="100" class="img-fluid" src="img/Documents/<?php echo $border['proof_photo']; ?>" alt="Proof Photo">
                                <input class="form-control" name="proof_photo" type="file">
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
                                <button class="btn btn-primary" name="update_border" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-secondary" type="reset"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include 'inc/footer.php'; ?>