<?php
include '../../dbconn.php';

$id = $_GET['ids'];
$delete = "DELETE FROM user WHERE id = $id";
$deletequery = mysqli_query($conn, $delete);
if($deletequery){
    ?>
<script>
    window.location.replace("index.php");
</script>

<?php 

}else{
    echo 'Not deleted';
}

?>