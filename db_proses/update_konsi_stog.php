<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$nota = $_POST['nota'];
	$staff = $_POST['staff'];
	$off = $_POST['off'];
	$tgl = $_POST['tgl'];

  if (empty($nota)||empty($staff)||empty($off)||empty($tgl)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sl = "UPDATE tb_jual_konsi SET tgl_order_jk='$tgl', status_jk='SUCCESS', tgl_approv_jk=NOW(), gudang_jk='$staff' WHERE id_jk='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Transaksi Berhasil DiApprove";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal DiApprove";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	
	echo json_encode($status);
?>
