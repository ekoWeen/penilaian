<?php 
session_start() ;
include "koneksi.php";
 
$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM skripsi  WHERE nama = '$username' and NIM = '$password'";

$query = mysqli_query($koneksi,$sql);
$cek = mysqli_num_rows($query);

if($cek==1){
	$row = $query->fetch_assoc();
	$_SESSION['serverdata']['username'] = $row['username'];
?>

<script>
	window.location="soal.php";
</script>

<?php
unset($_SESSION['refresh']);
}
else{ //jika pass salah
?><script>
    alert ('Username atau password salah');
    window.location="index.php";
    </script>
<?php
		}
?>