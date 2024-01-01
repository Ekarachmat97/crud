<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>dashboard admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        body {
            color: rgb(156, 131, 33);
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }
    </style>
</head>
<body>
<?php
include '../../dbconn.php';

// Periksa apakah ID diberikan di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data produk berdasarkan ID
    $update = "SELECT * FROM produk WHERE id = $id";
    $updatequery = mysqli_query($conn, $update);

    // Periksa apakah data ditemukan
    if ($result = mysqli_fetch_assoc($updatequery)) {
        if (isset($_POST['submit'])) {
            $id = $_GET['id'];
            $namaproduk = mysqli_real_escape_string($conn, $_POST['namaproduk']);
            $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
            $harga = mysqli_real_escape_string($conn, $_POST['harga']);
            $stock = mysqli_real_escape_string($conn, $_POST['stock']);

            // Query untuk melakukan update data produk
            $insertquery = "UPDATE produk SET namaproduk ='$namaproduk', deskripsi='$deskripsi', harga ='$harga', stock ='$stock' WHERE id = $id";
            $mysqliquery = mysqli_query($conn, $insertquery);

            // Periksa apakah update berhasil
            if ($mysqliquery) {
                ?>
                <script>
                    window.location.replace("index.php");
                </script>
                <?php
            } else {
                echo 'Not Updated';
            }
        }
    } else {
        echo 'Data not found.';
    }
} else {
    echo 'ID not provided.';
}
?>

<div style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; text-align: center; font-size: 30px; position: relative; top: 150px;">
    <a href="#editEmployeeModal" class="edit" data-toggle="modal">Click Here to Update<i class="material-icons" data-toggle="tooltip" title="Update">&#xE254;</i></a>
</div>

<!-- Update Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h4 class="modal-title">Update Data Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name Produk</label>
                        <input type="text" name="namaproduk" class="form-control" value="<?php echo $result['namaproduk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" value="<?php echo $result['deskripsi']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?php echo $result['harga']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" value="<?php echo $result['stock']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" name="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- delete modele -->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <h4 class="modal-title">Delete Data Produk</h4>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
