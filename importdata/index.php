<!DOCTYPE html>
<html>
<head>
	<title>Import Excel Ke SQL Server dengan PHP</title>
</head>
<body>
	<style type="text/css">
		body{
			font-family: sans-serif;
		}
 
		p{
			color: green;
		}
	</style>
	<h2>IMPORT EXCEL KE SQL SERVER DENGAN PHP</h2>
 
	<?php 
	if(isset($_GET['berhasil'])){
		echo "<p>".$_GET['berhasil']." Data berhasil di import.</p>";
	}
	?>
 
	<a href="upload.php">IMPORT DATA</a>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>ALamat</th>
			<th>Telepon</th>
		</tr>
		<?php 
		include 'koneksi.php';
		$no=1;
		$data = sqlsrv_query($con,"SELECT id, nama, alamat, telepon FROM dbnow_qcf.data_pegawai");
		if ($data === false) {
			die("Gagal mengambil data: <pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
		}
		while($d = sqlsrv_fetch_array($data)){
			?>
			<tr>
				<th><?php echo $no++; ?></th>
				<th><?php echo $d['nama']; ?></th>
				<th><?php echo $d['alamat']; ?></th>
				<th><?php echo $d['telepon']; ?></th>
			</tr>
			<?php 
		}
		?>
 
	</table>
 
	<a href="https://www.malasngoding.com/import-excel-ke-mysql-dengan-php">www.malasngoding.com</a>
 
</body>
</html>
