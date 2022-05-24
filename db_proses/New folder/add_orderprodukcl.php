<?php
	include "koneksi.php";
	session_start();
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = "PO Pusat";
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];

	$sl = "UPDATE beli SET total_beli='$total', keterangan_beli='$ketsup' WHERE id_beli='$nota' AND status_beli='REQUEST' AND event_beli='OFFICE'";
	$reslt = mysqli_query($kon,$sl);

	$status['nilai']=1; //bernilai benar
	$status['error']="Data Orderan Berhasil Dikirim";
	$status['kode_nota']=$nota;
	
	echo json_encode($status);
?>
