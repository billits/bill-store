<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - error data kosong

	$kode_produk = strtoupper($_POST['kode_produk']);
	$nama_produk = $_POST['nama_produk'];
	$kategori = $_POST['kategori1'];

	if ($kategori == ""){
		$kategori = $_POST['kategori'];
	}

  if (empty($nama_produk)){
		$valid=1;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sqlll = "UPDATE tb_produk SET nama_produk='$nama_produk', kategori_produk='$kategori' WHERE id_produk='$kode_produk'";
    $result = mysqli_query($kon,$sqlll);	  
		
		if (!$result) {
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);  
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Produk Berhasil Dirubah";
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
