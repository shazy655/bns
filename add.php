<?php
session_start();

include('database/connection.php');

if (isset($_POST) && isset($_POST['name'])  && isset($_POST['price'])  && isset($_POST['sku']) && isset($_FILES['image'])) {

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { } else {
                $uploadOk = 0;
            }
        } else {
            $uploadOk = 0;
        }

        if ($uploadOk) {
            $query = "INSERT INTO `products` (`name`, `sku`, `price`, `image`,`description`) VALUES (:name,:sku,:price,:image,:desc)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam('sku', $_POST['sku']);
            $stmt->bindParam('name', $_POST['name']);
            $stmt->bindParam('price', $_POST['price']);
            $stmt->bindParam('image', $target_file);
            
            $stmt->bindParam('desc', $_POST['desc']);

            $stmt->execute();
            header("Location:add.php?success=1");
        } else {
            header("Location:add.php?success=0");
        }
    } else {
        header("Location:add.php?success=0");
    }
}


/***Header For All Pages **/
echo include('include/header.php');
echo include('include/header_main.php');
?>




<div class="row">
    <div class="container bootstrap snippet"><br>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if (isset($_GET['success']) && $_GET['success']==1) { ?>
                        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Success!</strong> Product Added Successfully.
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success']) && $_GET['success']==0) { ?>
                        <div class="alert alert-danger fade in alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Sorry!</strong>  Unable to Add Product.
                        </div>
                    <?php } ?>

                    <strong class=""><i class="fa fa-mouse-pointer"></i> Add products to sell</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="add.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="price">Price ($):</label>
                            <div class="col-sm-10">
                                <input type="number" name="price" class="form-control" id="price" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sku">SKU:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="sku" name="sku" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="desc">Description:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="desc" name="desc" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="image">Image:</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10"></div>
                            <div class="col-sm-2">
                                <button name="submit" type="submit" class="btn btn-default">Add</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
echo include('include/footer.php');
?>