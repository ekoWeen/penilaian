<?php
	session_start();
		include "koneksi.php";
?>
<?php
	$namamhs = $_POST['mhs'];
	$NIM = $_POST['nim'];
	$jawaban1 = $_POST['jwb1'];
	$jawaban2 = $_POST['jwb2'];
	$jawaban3 = $_POST['jwb3'];
	$jawaban4 = $_POST['jwb4'];
	$jawaban5 = $_POST['jwb5'];
	$jawaban6 = $_POST['jwb6'];

	$sql = "INSERT INTO skripsi (nama, nim, jawaban1, jawaban2, jawaban3, jawaban4, jawaban5, jawaban6) VALUES ('$namamhs', '$NIM', '$jawaban1', '$jawaban2', '$jawaban3', '$jawaban4', '$jawaban5', '$jawaban6')";

	if (!mysqli_query($koneksi, $sql)) {
		echo "Data gagal dimasukan";
	}
	else {
		echo "Data berhasil dimasukan";
	}
	header("refresh:5; url=inputdataDummy.php");
?>