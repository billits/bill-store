<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$kode_nota= $_POST['kode_nota'];	
	$kode_pro= $_POST['kode_pro'];	

  if (empty($kode_nota)||empty($kode_pro)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql = "DELETE FROM tb_detail_retur_transaksi WHERE id_detrettrans='$kode_nota' AND produk_detrettrans='$kode_pro'";
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
