<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Payments Log</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Payments Log</a></li>
        </ul>
    </div>
    <?php 

    $log = $connection->prepare("SELECT * FROM `paid_bills`");
    $log->execute();
    $log = $log->fetchAll();

    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Logs table</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Payment Id</th>
                                <th>Border</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($log as $value): ?>
                            <?php 
                                $stmt = $connection->prepare("SELECT `name` FROM `borders` WHERE `border_id` = :border_id");
                                $stmt->bindValue(':border_id', $value['border_id']);
                                $stmt->execute();
                                $name = $stmt->fetch();
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $value['payment_id']; ?></td>
                                <td><?php echo $name['name']; ?></td>
                                <td><?php echo $value['created_at ']; ?></td>
                                <td>
                                    <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="editBorder.php?border_id=<?php echo $value['border_id']; ?>"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</a>
                                    <a class="btn btn-danger btn-sm" href="deleteBorder.php?border_id=<?php echo $value['border_id']; ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Delete</a>
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