<?php
	include "koneksi.php";

	$cek=0;
	$valid=0;
	// 1 - data kosong

	$kode_nota= $_REQUEST['kode_nota'];
	$kode_pro= $_REQUEST['kode_pro'];
	
  if (empty($kode_nota)||empty($kode_pro)){
		$valid=1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql = "DELETE FROM tb_detail_jual WHERE nota_detjual='$kode_nota' AND produk_detjual='$kode_pro'";
		$result = mysqli_query($kon,$sql);
		
		if(!$result) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Direset";	
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Direset";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
