<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$id_region = strtoupper($_POST['kode_region']);
	$nama_region = ucwords(strtolower($_POST['nama_region']));

  if (empty($nama_region)||empty($id_region)){
		$valid=1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "UPDATE tb_region SET nama_region='$nama_region' WHERE id_region='$id_region'";
    $result = mysqli_query($kon,$sqlll);	  
	
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Region Berhasil Dirubah";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dirubah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
