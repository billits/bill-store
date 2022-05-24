<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];
	$acara = $_POST['event'];

  if (empty($total)||empty($nota)||empty($ketsup)||empty($kantor)||empty($staff)||empty($acara)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sl = "UPDATE tb_beli_event SET tgl_beli_event=NOW(), total_beli_event='$total', keterangan_beli_event='$ketsup' WHERE id_beli_event='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Order Berhasil Dikirim";
			$status['kode_nota']=$nota;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Diproses";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
