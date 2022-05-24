<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$id_kategori = $_POST['kode_kategori'];
	$nama_kategori = ucwords(strtolower($_POST['nama_kategori']));

  if (empty($nama_kategori)){
		$valid=1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "UPDATE tb_kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'";
    $result = mysqli_query($kon,$sqlll);	 

		if(!$result) { 
			$cek=$cek+1;
		}

		if($cek==0) {    
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Kategori Berhasil Dirubah";
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
