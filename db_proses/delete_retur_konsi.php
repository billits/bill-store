<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$kode_nota= $_REQUEST['kode_nota'];

  if (empty($kode_nota)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql1 = "DELETE FROM tb_retur_transaksi WHERE id_retur='$kode_nota'";
		$result1 = mysqli_query($kon,$sql1);		
		if(!$result1) {    
			$cek=$cek+1;
		}

		$sql = "DELETE FROM tb_detail_retur_transaksi WHERE id_detrettrans='$kode_nota'";
		$result = mysqli_query($kon,$sql);
		if(!$result) {    
			$cek=$cek+1;
		}
	
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Dihapus";	
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dihapus";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
