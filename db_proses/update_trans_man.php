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

  if (empty($staff)||empty($off)||empty($tgl)||empty($nota)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sl = "UPDATE tb_man_trans SET tgl_order_mt='$tgl', status_mt='SUCCESS', tgl_approv_mt=NOW(), gudang_mt='$staff' WHERE id_mt='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Diapprove";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Diapprove";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}
	
	echo json_encode($status);
?>
