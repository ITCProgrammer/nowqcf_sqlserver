<?php
ini_set("error_reporting", 1);
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$cek=sqlsrv_query($con,"SELECT no_mutasi from dbnow_qcf.tbl_mutasi_kain WHERE transid='$modal_id'");
	$rc=sqlsrv_fetch_array($cek);
	$modal1=sqlsrv_query($con,"DELETE FROM dbnow_qcf.tbl_prodemand WHERE transid='$modal_id' ");
	$modal2=sqlsrv_query($con,"DELETE FROM dbnow_qcf.tbl_mutasi_kain WHERE transid='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='HapusMutasi-$rc[no_mutasi]';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='HapusMutasi-$rc[no_mutasi]';</script>";
    }
?>