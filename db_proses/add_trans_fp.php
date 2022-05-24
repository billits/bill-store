<?php
	include "koneksi.php";

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];

  if (empty($total)||empty($nota)||empty($ketsup)||empty($kantor)||empty($staff)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sqlre= "SELECT * FROM tb_free_produk WHERE id_fp='$nota'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$tglr = $rowre['waktu_fp'];		

		$sl = "UPDATE tb_free_produk SET waktu_fp='$tglr', total_fp='$total', status_fp='SUCCESS', keterangan_fp='$ketsup'
		WHERE id_fp='$nota'";
		$reslt = mysqli_query($kon,$sl);
	
		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);     
			$status['nilai']=1; //bernilai benar
			$status['nott']=$nota; 
			$status['error']="Data Transaksi Berhasil Diproses";
		}else{     
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Transaksi Gagal Diproses";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
