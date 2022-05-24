<?php
	include "koneksi.php";

	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	
	$id_region = strtoupper($_POST['kode_region']);
	$nama_region = ucwords(strtolower($_POST['nama_region']));

  if (empty($id_region)||empty($nama_region)){
		$valid=1;
	}
	
	$sqlre= "SELECT * FROM tb_region WHERE id_region= '$id_region'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
      
	if($countre == 1) {				     
		$valid=2;    
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "INSERT INTO tb_region(id_region, nama_region) VALUES ('$id_region', '$nama_region')";
    $result = mysqli_query($kon,$sqlll);

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Region Berhasil Ditambahkan";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Kode Region Sudah Digunakan";
	}
	echo json_encode($status);
?>
