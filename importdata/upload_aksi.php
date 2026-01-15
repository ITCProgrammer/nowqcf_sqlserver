<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->
 
<?php 
require('excel_reader2.php');
require('SpreadsheetReader.php');
require('koneksi.php');
?>
 
<?php
// upload file xls
$target = basename($_FILES['filepegawai']['name']) ;
move_uploaded_file($_FILES['filepegawai']['tmp_name'], $target);
 
// beri permisi agar file xls dapat di baca
chmod($_FILES['filepegawai']['name'],0777);
 
// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['filepegawai']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);
 
// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){
 
	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$nama     = $data->val($i, 1);
	$alamat   = $data->val($i, 2);
	$telepon  = $data->val($i, 3);
 
	if($nama != "" && $alamat != "" && $telepon != ""){
		// input data ke database (table data_pegawai) via SQL Server
		$insertQuery = "INSERT INTO dbnow_qcf.data_pegawai (nama, alamat, telepon) VALUES (?, ?, ?)";
		$stmt = sqlsrv_query($con, $insertQuery, [$nama, $alamat, $telepon]);
		if ($stmt === false) {
			// hentikan proses dan beri pesan saat ada kegagalan insert
			$msgErr = print_r(sqlsrv_errors(), true);
			unlink($_FILES['filepegawai']['name']);
			die("Gagal import data: <pre>{$msgErr}</pre>");
		}
		$berhasil++;
	}
}
 
// hapus kembali file .xls yang di upload tadi
unlink($_FILES['filepegawai']['name']);
 
// alihkan halaman ke index.php
header("location:index.php?berhasil=$berhasil");
?>
