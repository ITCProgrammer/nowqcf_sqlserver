<?php
date_default_timezone_set('Asia/Jakarta');

// Koneksi ke SQL Server mengikuti konfigurasi utama
$hostSVR19      = "10.0.0.221";
$usernameSVR19  = "sa";
$passwordSVR19  = "Ind@taichen2024";
$nowqcf         = "dbnow_qcf";
$dbnow_qcf      = array("Database" => $nowqcf, "UID" => $usernameSVR19, "PWD" => $passwordSVR19);
$con            = sqlsrv_connect($hostSVR19, $dbnow_qcf);

if ($con === false) {
    die("Koneksi SQL Server gagal: <pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
}
