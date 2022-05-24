<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$kode_office = $_POST['kode_office'];
	$nama_office = ucwords(strtolower($_POST['nama_office']));
	$kota_office = strtoupper($_POST['kota_office']);
	$region_office = $_POST['region_office1'];

	if($region_office==""){
		$region_office = $_POST['region_office'];
	}

  if (empty($kode_office)||empty($nama_office)||empty($kota_office)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "UPDATE tb_office SET nama_office='$nama_office', kota_office='$kota_office', region_office='$region_office' WHERE id_office='$kode_office'";
		$result = mysqli_query($kon,$sqlll);	  

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Pegawai Berhasil Dirubah";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dirubah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
