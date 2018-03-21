<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add Rooms</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Rooms</a></li>
        </ul>
    </div>

    <?php 

    if (isset($_POST['add_room'])) {
        $room_desc = trim($_POST['room_desc']);
        $attach_bath = trim($_POST['attach_bath']);
        $fare = trim($_POST['fare']);
        $max_border = trim($_POST['max_border']);
        $errors = [];
        $msgs = [];

        //Check validation
        
        // if no error
        if (empty($errors)) {
            $query = $connection->prepare("INSERT INTO `rooms`(`room_desc`,`attach_bath`,`fare`,`max_border`) VALUES(:room_desc,:attach_bath,:fare,:max_border)");
            $query->bindValue(':room_desc',$room_desc);
            $query->bindValue(':attach_bath',$attach_bath);
            $query->bindValue(':fare',$fare);
            $query->bindValue(':max_border',$max_border);
            $query->execute();
        if($query->rowCount() === 1){

            $msgs[] = "Room Added Successfully !";
            
        }else{
            $errors[] = "Room Not Added Successfully !";
        }

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
                    <form class="row" action="rooms.php" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Room Description</label>
                                <input class="form-control" name="room_desc" type="text" placeholder="Enter Room Description">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Attach Bath</label>
                                <select name="attach_bath" class="form-control">
                                    <option value="Yes">--Select--</option>
        	                	    <option value="Yes">Yes</option>
        	                	    <option value="No">No</option>
        	                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Fare</label>
                                <input class="form-control" name="fare" type="text" placeholder="Ex. 12,000">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Max Border</label>
                                <input class="form-control" name="max_border" type="text" placeholder="Ex. 4">
                            </div>
                        </div>
                        <div class="form-group col-md-2 align-self-end">
                            <button class="btn btn-primary" name="add_room" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php 
            $stmt = $connection->prepare("SELECT * FROM `rooms`");
            $stmt->execute();
            $rooms = $stmt->fetchAll();
        ?>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Room Details</h3>
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Attach Bath</th>
                                <th>Fare</th>
                                <th>Max Border</th>
                                <th>Existing No. of Border</th>
                                <th>Status</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($rooms as $value): ?>

                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $value['room_desc']; ?></td>
                                <td><?php echo $value['attach_bath']; ?></td>
                                <td><?php echo $value['fare']; ?></td>
                                <td><?php echo $value['max_border']; ?></td>
                                <td><?php echo $value['existing_border']; ?></td>
                                <td>
                                    <?php if($value['status'] == 0){?>
                                       
                                        <a href="editRooms.php?room_id=<?php echo $value['room_id'] ;?>">
                                            <span class="badge badge-danger">Not Available</span>
                                        </a>
                                       
                                    <?php }elseif($value['status'] == 1) {?>

                                        <a href="editRooms.php?room_id=<?php echo $value['room_id'] ;?>">
                                            <span class="badge badge-success">Available</span>
                                        </a>
                                    <?php }?>
                                </td>
                                <!-- <td>
                                    <a class="btn btn-primary btn-sm" href="<?php //echo $value['room_id']; ?>"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</a>&nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="deleteRoom.php?room_id=<?php //echo $value['room_id']; ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Delete</a>
                                </td> -->
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'inc/footer.php'; ?>