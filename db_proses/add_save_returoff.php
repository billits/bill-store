<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_COOKIE['office_bill'];   
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$jum=0;

  if (empty($staff)||empty($nota)||empty($kantor)||empty($total)||empty($ketsup)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sl = "UPDATE tb_retur_event SET waktu_returevt=NOW(), status_returevt='PENDING', total_returevt='$total', keterangan_returevt='$ketsup' WHERE id_returevt='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['nott']=$nota; 
			$status['error']="Data Retur Berhasil Diproses";
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
