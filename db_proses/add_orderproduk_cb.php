<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = "PO Pusat";
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];

  if (empty($total)||empty($nota)||empty($staff)||empty($kantor)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		// $sl = "UPDATE tb_beli SET total_beli='$total', keterangan_beli='$ketsup', tgl_beli=NOW(), tgl_approv_beli=NOW() WHERE id_beli='$nota' AND status_beli='REQUEST' AND event_beli='OFFICE'";
		$sl = "UPDATE tb_po SET total_po='$total', keterangan_po='$ketsup', status_po='REQUEST', tgl_po=NOW(), tgl_approv_po=NOW() WHERE id_po='$nota'";
		$reslt = mysqli_query($kon,$sl);
		
		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Orderan Berhasil Dikirim";
			$status['kode_nota']=$nota;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
