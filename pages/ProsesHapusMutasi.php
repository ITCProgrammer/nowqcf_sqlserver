<?php
ini_set("error_reporting", 1);
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$cek=mysqli_query($con,"SELECT no_mutasi from tbl_mutasi_kain WHERE transid='$modal_id'");
	$rc=mysqli_fetch_array($cek);
	$modal1=mysqli_query($con,"DELETE FROM `tbl_prodemand` WHERE transid='$modal_id' ");
	$modal2=mysqli_query($con,"DELETE FROM `tbl_mutasi_kain` WHERE transid='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='HapusMutasi-$rc[no_mutasi]';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='HapusMutasi-$rc[no_mutasi]';</script>";
    }
?>