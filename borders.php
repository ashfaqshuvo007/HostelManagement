<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Borders List</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>
    <?php 

    $query = $connection->prepare("SELECT * FROM `borders`");
    $query->execute();
    $borders = $query->fetchAll();

    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Border List</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Room No.</th>
                                <th>Phone</th>
                                <th>Emer. Phone</th>
                                <th>E-mail</th>
                                <th>Father's Name</th>
                                <th>Mother's Name</th>
                                <th>Present Address</th>
                                <th>Permanent Address</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($borders as $value): ?>
                            <tr>
                                <td><?php echo $value['border_id']; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['room_id']; ?></td>
                                <td><?php echo $value['contact']; ?></td>
                                <td><?php echo $value['emr_contact']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo $value['f_name']; ?></td>
                                <td><?php echo $value['m_name']; ?></td>
                                <td><?php echo $value['pre_address']; ?></td>
                                <td><?php echo $value['perma_address']; ?></td>
                                <td><img class="img-fluid" src="img/borders/<?php echo $value['photo']; ?>" alt=""></td>
                                <td>
                                    <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="editBorder.php?border_id=<?php echo $value['border_id']; ?>"><i class="fa fa-fw fa-lg fa-edit"></i></a>
                                    <a class="btn btn-danger btn-sm" href="borderDelete.php?border_id=<?php echo $value['border_id']; ?>"><i class="fa fa-fw fa-lg fa-trash"></i></a>
                                    </div>
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