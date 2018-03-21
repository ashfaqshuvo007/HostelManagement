<?php include 'inc/header.php'; ?>
<!-- Sidebar menu-->
<aside class="app-sidebar">
    <?php include 'inc/sidebar.php'; ?>
</aside>
<main class="app-content">
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Documents List</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Documents</a></li>
        </ul>
    </div>
    <?php 

    $query = $connection->prepare("SELECT * FROM `documents`");
    $query->execute();
    $documents = $query->fetchAll();


    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Borders Document</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>NID No</th>
                                <th>Photo</th>
                                <th>Proof Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($documents as $value): ?>
                            <?php 
                                $name = $value['border_id'];
                                $stmt = $connection->prepare("SELECT `name` FROM `borders` WHERE `border_id` = :border_id");
                                $stmt->bindValue(':border_id', $name);
                                $stmt->execute();
                                $border = $stmt->fetch();


                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $border['name']; ?></td>
                                <td><?php echo $value['nid']; ?></td>
                                <td><img width="100" class="img-fluid" src="img/borders/<?php echo $value['photo']; ?>" alt=""></td>
                                <td><img width="100" class="img-fluid" src="img/Documents/<?php echo $value['proof_photo']; ?>" alt=""></td>
                                <td>
                                    <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="#"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</a>
                                    <a class="btn btn-danger btn-sm" href="deleteDoc.php?doc_id=<?php echo $value['doc_id']; ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Delete</a>
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