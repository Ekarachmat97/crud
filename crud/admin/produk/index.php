<?php
session_start();
include("../../dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Dashboard_admin</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
<a class="navbar-brand" href="#">
        <?php
        // Periksa apakah sudah login
        if (isset($_SESSION['log']) && $_SESSION['log'] === 'Logged') {
            echo 'Halo ' . $_SESSION['username'];
        } else {
            echo 'Login';
        }
        ?>
    </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../user/">User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Setting</a>
                </li>
            </ul>
        </div>
    </nav>
    
	<div class="crud">
		<h1 style="font-size:30px;"><b>DASBOARD ADMIN</b></h1>
	</div>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				
				<div class="row">
					<div class="col-sm-6">
						<h2>Kelola Produk</h2>
					</div>
					<div class="col-sm-6 text-start" style="margin: 15px 0;">
						<a href="#addEmployeeModal" class="btn btn-success " data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Tambahkan produk</span></a>
						<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						
					</div>
				</div>
			</div>
			
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name Produk</th>
						<th>Gambar</th>
						<th>Deskripsi</th>
						<th>Harga</th>
						<th>Stock</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
			<?php
			include '../../dbconn.php';
			$query = 'SELECT * FROM produk';
			$mysqliquery = mysqli_query($conn, $query);
			while ($result = mysqli_fetch_assoc($mysqliquery)) {
				?>
				<tr>
					<td>
						<?php echo $result['id']; ?>
					</td>
					<td>
						<?php echo $result['namaproduk']; ?>
					</td>
					<td>
                        <?php if (!empty($result['gambar'])): ?>
                        <img src="<?php echo $result['gambar']; ?>" alt="<?php echo $result['namaproduk']; ?>" style="width: 100px; height: 100px;">
                        <?php endif; ?>
                    </td>
					<td>
						<?php echo $result['deskripsi']; ?>
					</td>
					<td>
						<?php echo $result['harga']; ?>
					</td>
					<td>
						<?php echo $result['stock']; ?>
					</td>
			
			
					<td>
						<a href="update.php?id=<?php echo $result['id']; ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Update">&#xE254;</i></a>
						<a href="delete.php?ids=<?php echo $result['id']; ?>" class="delete"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
					</td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			
	</div>        
</div>
<!-- Add product HTML -->
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="insert.php" enctype="multipart/form-data">
				<div class="modal-header">						
					<h4 class="modal-title">Tambah Produk</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name Produk</label>
						<input type="text" name="namaproduk" class="form-control" required>
					</div>
					<div class="form-group">
					<label for="gambar">Product Image:</label>
					<input type="file" name="gambar" id="gambar" accept="image/*">	
					</div>
					<div class="form-group">
						<label>Harga</label>
						<input type="number" name="harga" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea class="form-control" name="deskripsi"  required></textarea>
					</div>
					<div class="form-group">
						<label>Stock</label>
						<input type="number" name="stock" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" name="tambahproduk" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>



<!-- Update Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Update Data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Nama Produk</label>
						<input type="text" class="form-control" required>
					</div>
					<div class="form-group">
					<label for="gambar">Product Image:</label>
					<input type="file" name="gambar" id="gambar" accept="image/*">	
					</div>
					<div class="form-group">
						<label>Harga</label>
						<input type="text" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Stock</label>
						<input type="number" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
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
				<div class="modal-header">						
					<h4 class="modal-title">Delete Data</h4>
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
<style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #3d3d3d;
            color: #ffffff;
        }

        .crud {
            background-color: #fff;
            color: #000;
            padding: 10px;
            text-align: center;
        }

        .table-title h2 {
          margin-top: 30px;
            color: #007bff;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .modal-header {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</body>
</html>